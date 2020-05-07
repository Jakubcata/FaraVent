<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use View as Viewrender;


class AdminController extends Controller
{
  public function index(Request $request){

      return view('index', ['status'=>"done"]);
  }




}
