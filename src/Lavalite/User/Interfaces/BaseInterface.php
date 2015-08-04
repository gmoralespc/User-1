<?php namespace Lavalite\User\Interfaces;

interface BaseInterface
{
    /**
     * Base methods
     */

    public function all();

    public function create(array $credentials);

    public function json();

    public function find($id);

    public function findOrNew($id);

    public function update($id, $array);

    public function delete($id);

    public function destroy($ids);

    public function instance();

}