<?php

namespace Modules\CRM\App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ClientInvoiceController extends Controller
{
	public function index()
	{
        if (request()->ajax())
        {
            return datatables()->of(Invoice::with('project:id,title')->get())
                ->setRowId(function ($invoice)
                {
                    return $invoice->id;
                })
                ->addColumn('project', function ($row)
                {
                    $project_name = empty($row->project->title) ? '' : $row->project->title;

                    return $project_name;
                })
                ->addColumn('action', function ($data)
                {
                    $button = '<a  class="show btn btn-success btn-sm" href="' . route('invoices.show', $data) . '"><i class="dripicons-preview"></i></a>';
                    $button .= '&nbsp;&nbsp;';
                    if (auth()->user()->can('edit-invoice'))
                    {
                        $button .= '<a id="' . $data->id . '" class="edit btn btn-primary btn-sm" href="' . route('invoices.edit', $data) . '"><i class="dripicons-pencil"></i></a>';
                        $button .= '&nbsp;&nbsp;';
                    }
                    if (auth()->user()->can('delete-invoice'))
                    {
                        $button .= '<button type="button" name="delete" id="' . $data->id . '" class="delete btn btn-danger btn-sm"><i class="dripicons-trash"></i></button>';
                    }

                    return $button;

                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('crm::client.invoices.index');
	}
}
