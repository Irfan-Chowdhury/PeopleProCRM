<?php

namespace Modules\CRM\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\File;
use Modules\CRM\App\Http\Requests\LeadFile\StoreLeadFileRequest;
use Modules\CRM\App\Models\Lead;
use Modules\CRM\App\Models\LeadFile;

class LeadFileController extends Controller
{
    public function index(Lead $lead)
    {
        return view('crm::lead_section.files.index', compact('lead'));
    }

    public function datatable(Lead $lead)
    {
        if (request()->ajax())
		{
			return datatables()->of(LeadFile::all())
				->setRowId(function ($file)
				{
					return $file->id;
				})
				->addColumn('file_description', function ($row) use ($lead)
				{
					if ($row->file_description)
					{
                        return $row->file_description . '<br><h6><a href="' . url('leads/details/' . $lead->id . '/files/file_download/' . $row->id) . '">' . trans('file.File') . '</a></h6>';
                        // return $row->file_description .'<br><h6><a href="leads/details/'.$lead->id.'/files/file_download/'.$row->id.'/">' . trans('file.File') . '</a></h6>';
					}
				})
				->addColumn('created_at', function ($row)
				{
					return date('Y-m-d', strtotime($row->created_at));
				})
                ->addColumn('action', function ($data)
                {
                    return'<button type="button" data-id="'.$data->id.'" class="delete btn btn-danger btn-sm"><i class="dripicons-trash"></i></button>';
                })
				->rawColumns(['action', 'file_description'])
				->make(true);

		}
    }

    public function store(StoreLeadFileRequest $request, Lead $lead)
	{

		$data = [
            'lead_id' => $request->lead_id,
            'file_title' => $request->file_title,
            'file_description' => $request->file_description,
            'file_attachment' => self::fileUploadHandle($request->file_attachment, 'uploads/crm/lead_file_attachments', 'file')
        ];

		LeadFile::create($data);

        return response()->json(['success' =>'Data Submitted Successfully'], 200);
	}

    public function destroy(Lead $lead, LeadFile $leadFile)
    {
        self::previousFileDelete('uploads/crm/lead_file_attachments', $leadFile->file_attachment);
        $leadFile->delete();
        return response()->json(['success' =>'Data Deleted Successfully'], 200);
    }

    public function bulkDelete(Request $request)
    {
        $idsArray = $request['idsArray'];

        try {
            $leadFile = LeadFile::whereIntegerInRaw('id', $idsArray);

            foreach ($leadFile->get() as $item) {
                self::previousFileDelete('uploads/crm/lead_file_attachments', $item->file_attachment);
            }

            $leadFile->delete();

            return response()->json(['success' =>'Data Deleted Successfully'], 200);

        } catch (Exception $e) {
            return response()->json(['errorMsg' =>$e->getMessage()], 422);
        }
    }

    public function download(Lead $lead, LeadFile $leadFile)
	{
		$file_path = $leadFile->file_attachment;

		$download_path = public_path("uploads/crm/lead_file_attachments/" . $file_path);

		if (file_exists($download_path))
		{
			$response = response()->download($download_path);

			return $response;
		} else
		{
			return abort('404', __('File not Found'));
		}
	}

    protected function previousFileDelete(string $directory, string|null $prevFileName) : void
    {
        if($prevFileName && File::exists(public_path($directory).'/'.$prevFileName))
            File::delete(public_path($directory).'/'.$prevFileName);
    }




    protected function fileUploadHandle(object|null $file, string $directory, string $name): string | null
    {
		if (isset($file)) {
			if ($file->isValid()) {

				$fullFileName = 'lead_file_' . time() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path($directory), $fullFileName);

				return $fullFileName;
			}
		}
        return null;
    }
}
