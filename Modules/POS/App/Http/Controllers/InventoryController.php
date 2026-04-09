<?php
namespace Modules\POS\App\Http\Controllers;
use App\Http\Controllers\Controller;
class InventoryController extends Controller {
    public function index() { return view('pos::inventory.index'); }
}
