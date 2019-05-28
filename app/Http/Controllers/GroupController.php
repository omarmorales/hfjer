<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PDF;
use App\Group;

class GroupController extends Controller
{
    public function export_pdf($id)
    {
      $group = Group::find($id);
      $pdf = PDF::loadView('pdf.invoice', compact('group'));
      return $pdf->download('details.pdf');
    }
}
