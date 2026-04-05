<?php

namespace App\Http\Controllers\GPAdmin;

use App\Http\Controllers\Controller;
use App\Models\TaxDocument;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

class TaxDocumentController extends Controller
{
    protected $gp_name_in_url;
    protected $gp_name;
    protected $gp_user_id;

    public function __construct()
    {
        $this->gp_name_in_url = Session::get('gp_name_in_url');
        $this->gp_name = Session::get('gp_name');
        $this->gp_user_id = Session::get('gp_user_id');
    }

    public function index()
    {
        $taxTypes     = ['ghar_patti', 'paani_patti', 'other'];
        $documentTypes = ['view_pdf', 'payment_qr'];

        $activeDocuments = TaxDocument::where('gp_name_in_url', $this->gp_name_in_url)
            ->where('is_active', true)
            ->get()
            ->groupBy(['tax_type', 'document_type']);

        return view('gpadmin.tax-documents.index', compact('taxTypes', 'documentTypes', 'activeDocuments'));
    }

    public function store(Request $request)
    {
        $documentType = $request->input('document_type');

        if ($documentType === 'view_pdf') {
            $request->validate([
                'tax_type'      => 'required|in:ghar_patti,paani_patti,other',
                'document_type' => 'required|in:view_pdf,payment_qr',
                'file'          => 'required|mimes:pdf|max:10240',
            ]);
        } else {
            $request->validate([
                'tax_type'      => 'required|in:ghar_patti,paani_patti,other',
                'document_type' => 'required|in:view_pdf,payment_qr',
                'file'          => 'required|mimes:jpg,jpeg,png,pdf|max:5120',
            ]);
        }

        // Deactivate previous active doc for same slot
        TaxDocument::where('gp_name_in_url', $this->gp_name_in_url)
            ->where('tax_type', $request->tax_type)
            ->where('document_type', $request->document_type)
            ->where('is_active', true)
            ->update(['is_active' => false]);

        $uploadedFile = $request->file('file');
        $filePath = $uploadedFile->store($this->gp_name_in_url . '/tax-documents', 'public');
        $fileName  = $uploadedFile->getClientOriginalName();

        TaxDocument::create([
            'gp_name_in_url' => $this->gp_name_in_url,
            'tax_type'       => $request->tax_type,
            'document_type'  => $request->document_type,
            'file_path'      => $filePath,
            'file_name'      => $fileName,
            'is_active'      => true,
        ]);

        return redirect()->route('gpadmin.gp-tax.documents.index')->with('success', 'कागदपत्र यशस्वीरित्या अपलोड झाले.');
    }

    public function destroy($document)
    {
        $doc = TaxDocument::where('id', $document)
            ->where('gp_name_in_url', $this->gp_name_in_url)
            ->firstOrFail();

        if ($doc->file_path && Storage::disk('public')->exists($doc->file_path)) {
            Storage::disk('public')->delete($doc->file_path);
        }

        $doc->delete();

        return redirect()->route('gpadmin.gp-tax.documents.index')->with('success', 'कागदपत्र यशस्वीरित्या हटवले.');
    }
}
