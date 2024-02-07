<?php

namespace Modules\CRM\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Modules\CRM\App\Http\Requests\LeadContact\StoreRequest;
use Modules\CRM\App\Http\Requests\LeadContact\UpdateRequest;
use Modules\CRM\App\Models\Lead;
use Modules\CRM\App\Models\LeadContact;

class LeadContactController extends Controller
{
    public function index(Lead $lead)
    {
        return view('crm::lead_section.contact.index', compact('lead'));
    }

    public function datatable()
    {
        if (request()->ajax())
		{
			return datatables()->of(LeadContact::all())
				->setRowId(function ($row)
				{
					return $row->id;
				})
                ->addColumn('image',function ($row)
                {
                    if ($row->image) {
                        $url = url('uploads/crm/lead_contacts/'.$row->image);
                        $image = '<img src="'.$url.'" class="profile-photo md" style="height:35px;width:35px"/>';
                    } else {
                        $url = url('logo/avatar.jpg');
                        $image = '<img src="'.$url.'" class="profile-photo md" style="height:35px;width:35px"/>';
                    };

                    return $image;
                })
                ->addColumn('name',function ($row)
                {
                    $data = $row->first_name.' '.$row->last_name;
                    if($row->is_primary_contact)
                        $data .= '<span class="ml-2 badge badge-pill badge-primary">Primary Contact</span>';

                    return $data;
                })
                ->addColumn('email',function ($row)
                {
                    return $row->email ?? "" ;
                })
                ->addColumn('phone',function ($row)
                {
                    return $row->phone ?? "" ;
                })
				->addColumn('action', function ($data)
                {
                    $button = '<button type="button" data-id="'. $data->id . '" class="edit btn btn-primary btn-sm"><i class="dripicons-pencil"></i></button>';
                    $button .= '&nbsp;&nbsp;';
                    $button .= '<button type="button" data-id="'.$data->id.'" class="delete btn btn-danger btn-sm"><i class="dripicons-trash"></i></button>';
                    return $button;
                })
                ->rawColumns(['image','name','action'])
                ->make(true);
		}
    }

    public function store(StoreRequest $request, Lead $lead)
    {
        if($request->is_primary_contact) {
            LeadContact::where('is_primary_contact',true)->update(['is_primary_contact' => false]);
        }

        LeadContact::create([
            'lead_id' => $lead->id,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'gender' => $request->gender,
            'job_title' => $request->job_title,
            'image' => self::fileUploadHandle($request->image, 'uploads/crm/lead_contacts', 'contact'),
            'is_primary_contact' => $request->is_primary_contact ? true : false,
        ]);
        return response()->json(['success' =>'Data Submitted Successfully'], 200);
    }

    public function edit(Lead $lead, LeadContact $leadContact)
    {
        return response()->json(['leadContact' => $leadContact]);
    }

    public function update(UpdateRequest $request, Lead $lead, LeadContact $leadContact)
    {
        if($request->is_primary_contact) {
            LeadContact::where('is_primary_contact',true)->update(['is_primary_contact' => false]);
        }

        $leadContact->update([
            'lead_id' => $lead->id,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'gender' => $request->gender,
            'job_title' => $request->job_title,
            'image' => self::fileUploadHandle($request->image, 'uploads/crm/lead_contacts', 'contact', $leadContact->image),
            'is_primary_contact' => $request->is_primary_contact ? true : false,
        ]);

        return response()->json(['success' =>'Data Updated Successfully'], 200);
    }


    public function destroy(Lead $lead, LeadContact $leadContact)
    {
        self::previousFileDelete('uploads/crm/lead_contacts', $leadContact->image);
        $leadContact->delete();
        return response()->json(['success' =>'Data Deleted Successfully'], 200);
    }


    public function bulkDelete(Request $request)
    {
        $idsArray = $request['idsArray'];

        try {
            $leadContact = LeadContact::whereIntegerInRaw('id', $idsArray);

            foreach ($leadContact->get() as $item) {
                self::previousFileDelete('uploads/crm/lead_contacts', $item->image);
            }

            $leadContact->delete();

            return response()->json(['success' =>'Data Deleted Successfully'], 200);

        } catch (Exception $e) {
            return response()->json(['errorMsg' =>$e->getMessage()], 422);
        }
    }

    protected function fileUploadHandle(object|null $file, string $directory, string $name, string $prevFileName = null): string | null
    {
		if (isset($file)) {
			if ($file->isValid()) {

                self::previousFileDelete($directory, $prevFileName);

				$fullFileName = preg_replace('/\s+/', '', $name) . '_' . time() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path($directory), $fullFileName);

				return $fullFileName;
			}
		}
        return null;
    }

    protected function previousFileDelete(string $directory, string|null $prevFileName) : void
    {
        if($prevFileName && File::exists(public_path($directory).'/'.$prevFileName))
            File::delete(public_path($directory).'/'.$prevFileName);
    }



}
