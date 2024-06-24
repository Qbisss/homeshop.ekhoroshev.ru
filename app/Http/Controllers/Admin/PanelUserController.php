<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\User;

class PanelUserController extends Controller
{
    public function searchuser(Request $request)
    {
        if(!$request->search)
            return response()->json(['error' => "Пользователь не найден"]);

        $user = User::where('id', $request->search)->orWhere('phone', $request->search)->orWhere('email', $request->search)->first();
        if(!$user)
            return response()->json(['error' => "Пользователь не найден"]);

            $data = '  <thead>
  <tr>
    <th scope="col">id</th>
    <th scope="col">Телефон</th>
    <th scope="col">Mail</th>
  </tr>
</thead>
          <tbody>
              <tr>
                  <th scope="row">'.$user->id.'</th>
                  <td>'.$user->phone.'</td>
                  <td>'.$user->email.'</td>
              </tr>';

              return response()->json(['data' => $data]);
    }
}
