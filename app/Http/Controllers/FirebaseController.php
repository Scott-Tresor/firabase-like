<?php

namespace App\Http\Controllers;

use Google\Cloud\Firestore\FirestoreClient;
use Illuminate\Http\Request;
use Kreait\Firebase\Auth;
use Kreait\Firebase\Exception\DatabaseException;
use Kreait\Firebase\Factory;


class FirebaseController extends Controller
{
    private $firebase;

    public function __construct()
    {
        $this->firebase = new FirestoreClient([
            'keyFilePath' => __DIR__.'/Firebase.json',
            'id' => 'quickstart-1558014300056'
        ]);
    }

    public function index()
    {
        $data = $this->firebase->collection('blog');
        $collection  = $data->documents();
        foreach ($collection as $item => $value){
            dd($value);
        }
    }

    public function store(Request $request)
    {
        try {
            $information  = $request->validate([
                'username' => 'required|min:4',
                'name' => 'required|min:4',
                'password' => 'required|min:4'
            ]);
            $this->firebase->collection('blog')->add($information);
            return  response([
                'data' => $information
            ]);
        } catch (\Exception $exception) {
            return response([
                'code' => $exception->getCode(),
                'message' => $exception->getMessage()
            ]);
        } catch (DatabaseException $e) {
            return response([
                'e' => $e->getMessage()
            ]);
        }

    }

    public function show()
    {
        $docRef = $this->firebase->collection('blog');
        $query = $docRef->where('username', '=', 'tresor');
        $documents = $query->documents();
    }

    public function update($name)
    {
        $docRef = $this->firebase->collection('users')->document($name);
        $information  = request()->validate([
            'username' => 'required|min:4',
            'name' => 'required|min:4',
            'password' => 'required|min:4'
        ]);
    }

    public function destroy()
    {

    }

    public function createUser()
    {

    }

}

