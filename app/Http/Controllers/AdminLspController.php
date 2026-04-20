<?php

namespace App\Http\Controllers;

use App\Models\LspForm;
use Illuminate\Http\Request;
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\IOFactory;
use PhpOffice\PhpWord\Shared\Html;

class AdminLspController extends Controller
{
    public function index()
    {
        $forms = LspForm::latest()->paginate(10);
        return view('admin.lsp-index', compact('forms'));
    }

    public function exportDocx($id)
    {
        $form = LspForm::findOrFail($id);

        $phpWord = new PhpWord();
        $section = $phpWord->addSection();

        $section->addText('ABSENSI SISWA LSP', ['bold' => true, 'size' => 16], ['alignment' => 'center']);
        $section->addTextBreak(1);

        $section->addText("Nama: {$form->nama}");
        $section->addText("Asal Sekolah: {$form->asal_sekolah}");
        $section->addTextBreak(1);

        $section->addText('Tanda Tangan:', ['bold' => true]);
        
        // Handle Base64 signature
        $signatureData = str_replace('data:image/png;base64,', '', $form->signature);
        $signatureData = base64_decode($signatureData);
        $tempFile = tempnam(sys_get_temp_dir(), 'sig') . '.png';
        file_put_contents($tempFile, $signatureData);

        $section->addImage($tempFile, ['width' => 100, 'height' => 50]);

        $objWriter = IOFactory::createWriter($phpWord, 'Word2007');
        $fileName = "Absensi_LSP_{$form->nama}.docx";
        $filePath = storage_path("app/public/{$fileName}");
        $objWriter->save($filePath);

        return response()->download($filePath)->deleteFileAfterSend(true);
    }

    public function destroy($id)
    {
        $form = LspForm::findOrFail($id);
        $form->delete();

        return redirect()->back()->with('success', 'Data absensi berhasil dihapus!');
    }
}
