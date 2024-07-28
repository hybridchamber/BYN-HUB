<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateBulletinBoardRequest;
use App\Http\Resources\BulletinBoardResource;
use App\Models\BulletinBoard;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Storage;
use Dompdf\Dompdf;
use PhpOffice\PhpWord\IOFactory;

class BulletinBoardController extends Controller
{
    use AuthorizesRequests;

    public function index(): Response
    {
        $bulletinboards = BulletinBoard::all();

        return Inertia::render('Admin/BulletinBoards/BulletinBoardIndex', [
            'bulletinboards' => BulletinBoardResource::collection($bulletinboards)
        ]);
    }

    public function create(): Response
    {
        $this->authorize('create', BulletinBoard::class);
        return Inertia::render('Admin/BulletinBoards/Create');
    }

    public function store(CreateBulletinBoardRequest $request): RedirectResponse
    {
        $this->authorize('create', BulletinBoard::class);

        $validatedData = $request->validated();

        if ($request->hasFile('bb_file')) {
            $file = $request->file('bb_file');
            $validatedData['bb_file'] = $this->convertToPdf($file);
            $validatedData['bb_file'] = $request->file('bb_file')->store('public/bulletinboard_files');
        }

        BulletinBoard::create($validatedData);

        return redirect()->route('bulletinboards.index');
    }
    public function edit(BulletinBoard $bulletinboard): Response
{
    $this->authorize('update', $bulletinboard);

    return Inertia::render('Admin/BulletinBoards/Edit', [
        'bulletinboard' => new BulletinBoardResource($bulletinboard)
    ]);
}

    public function update(CreateBulletinBoardRequest $request, BulletinBoard $bulletinboard): RedirectResponse
    {
        $this->authorize('update', $bulletinboard);

        $validatedData = $request->validated();

        if ($request->hasFile('bb_file')) {
            if ($bulletinboard->bb_file) {
                Storage::delete($bulletinboard->bb_file);
            }
            $file = $request->file('bb_file');
            $validatedData['bb_file'] = $this->convertToPdf($file);
            $validatedData['bb_file'] = $request->file('bb_file')->store('public/bulletinboard_files');
        } else {
            $validatedData['bb_file'] = $bulletinboard->bb_file;
        }

        $bulletinboard->update($validatedData);

        return redirect()->route('bulletinboards.index');
    }

    public function destroy(BulletinBoard $bulletinboard): RedirectResponse
    {
        $this->authorize('delete', $bulletinboard);
        $bulletinboard->delete();
        return back();
    }

    private function convertToPdf($file)
    {
        $extension = $file->getClientOriginalExtension();

        if ($extension === 'docx') {
            return $this->convertDocxToPdf($file);
        }

        // Add additional file type conversions if needed

        // Default case: store the file as is
        return $file->store('public/bulletinboard_files');
    }

    private function convertDocxToPdf($file)
    {
        // Load the DOCX file with PHPWord
        $phpWord = IOFactory::load($file->getPathname());

        // Create a temporary HTML file from the DOCX content
        $htmlWriter = IOFactory::createWriter($phpWord, 'HTML');
        $tempHtmlPath = storage_path('app/temp/temp.html');
        $htmlWriter->save($tempHtmlPath);

        // Convert the temporary HTML file to PDF with DomPDF
        $dompdf = new Dompdf();
        $htmlContent = file_get_contents($tempHtmlPath);
        $dompdf->loadHtml($htmlContent);
        $dompdf->render();

        // Save the PDF to storage
        $pdfPath = 'public/bulletinboard_files/' . uniqid() . '.pdf';
        Storage::put($pdfPath, $dompdf->output());

        // Clean up the temporary HTML file
        unlink($tempHtmlPath);

        return $pdfPath;
    }


}
