<?php

namespace Modules\Users\Repositories;

use App\Repositories\RepositoryInterface;
use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\QueryException;
use Mockery\Exception;
use Modules\Users\Models\Users;

class UsersRepository implements RepositoryInterface
{
    // model property on class instances
    protected $model;

    // Constructor to bind model to repo
    public function __construct()
    {
        $this->model = new User();
    }

    // Get all instances of model
    public function all()
    {
        $columns = [
            'id',
            'name',
            'login',
            'phone',
            'role',
            'access_users',
            'access_records',
            'notificate',
        ];
        $users = $this->model->all($columns);
        $result=[];
        foreach ($users as $user) {
            $result[$user->id] = $user;
        }
        return $result;
    }

    // create a new record in the database
    public function create(array $data)
    {
        return $this->model->create($data);
    }

    // update record in the database
    public function update(array $data, $id)
    {
        $user   = $this->model->find($id);
        $result = $user->fill($data)->save();
        return $result;
    }

    // remove record from the database
    public function delete($id)
    {
        try {
            return $this->model->destroy($id);
        } catch (QueryException $ex){
            if($ex->getCode() === '23t000') {
                \Session::flash('msg_error', 'Нельзя удалить пользователя, у которого есть записи. Отключите доступ.');
                return redirect()->back();
            }
            \Session::flash('msg_error', 'Ошибка удаления пользователя!');
            return redirect()->back();
        }
    }

    // show the record with the given id
    public function show($id)
    {
        return $this->model->findOrFail($id);
    }

    // Get the associated model
    public function getModel()
    {
        return $this->model;
    }

    // Set the associated model
    public function setModel($model)
    {
        $this->model = $model;
        return $this;
    }

    // Eager load database relationships
    public function with($relations)
    {
        return $this->model->with($relations);
    }
}
