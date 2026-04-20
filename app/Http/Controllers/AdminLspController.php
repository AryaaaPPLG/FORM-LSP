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
        if (strpos($form->signature, ',') !== false) {
            try {
                $data = explode(',', $form->signature);
                $signatureData = base64_decode($data[1]);
                $tempFile = tempnam(sys_get_temp_dir(), 'sig') . '.png';
                file_put_contents($tempFile, $signatureData);

                $section->addImage($tempFile, ['width' => 120, 'height' => 60]);
                
                // Cleanup
                @unlink($tempFile);
            } catch (\Exception $e) {
                $section->addText('[Gambar tanda tangan tidak dapat dimuat]');
            }
        }

        $objWriter = IOFactory::createWriter($phpWord, 'Word2007');
        $fileName = "Absensi_LSP_{$form->nama}.docx";
        $filePath = storage_path("app/public/{$fileName}");
        $objWriter->save($filePath);

        return response()->download($filePath)->deleteFileAfterSend(true);
    }

    public function exportAllDocx()
    {
        $forms = LspForm::all();

        $phpWord = new PhpWord();
        $section = $phpWord->addSection();

        $section->addText('DAFTAR ABSENSI SISWA LSP', ['bold' => true, 'size' => 16], ['alignment' => 'center']);
        $section->addTextBreak(1);

        $table = $section->addTable(['borderSize' => 6, 'borderColor' => '000000', 'cellMargin' => 80]);
        
        // Header
        $table->addRow();
        $table->addCell(500)->addText('No', ['bold' => true]);
        $table->addCell(3000)->addText('Nama', ['bold' => true]);
        $table->addCell(3000)->addText('Asal Sekolah', ['bold' => true]);
        $table->addCell(2500)->addText('Tanda Tangan', ['bold' => true]);

        foreach ($forms as $index => $form) {
            $table->addRow();
            $table->addCell(500)->addText($index + 1);
            $table->addCell(3000)->addText($form->nama);
            $table->addCell(3000)->addText($form->asal_sekolah);
            
            $cell = $table->addCell(2500);
            if (strpos($form->signature, ',') !== false) {
                try {
                    $data = explode(',', $form->signature);
                    $signatureData = base64_decode($data[1]);
                    $tempFile = tempnam(sys_get_temp_dir(), 'sig') . '.png';
                    file_put_contents($tempFile, $signatureData);
                    
                    $cell->addImage($tempFile, ['width' => 80, 'height' => 40]);
                    
                    @unlink($tempFile);
                } catch (\Exception $e) {
                    $cell->addText('Error signature');
                }
            } else {
                $cell->addText('Invalid data');
            }
        }

        $objWriter = IOFactory::createWriter($phpWord, 'Word2007');
        $fileName = "Rekap_Absensi_LSP_" . date('Y-m-d') . ".docx";
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
