<?php


namespace App\Services;


/**
 * Interface DiaryInterface
 * @package App\Services
 */
interface DiaryInterface
{


    /**
     * @param int $diary_srl
     * @param int $user_id
     * @return mixed
     */
    public function destroy(int $diary_srl, int $user_id): void;
    /**
     * @param Object $formData
     * @return mixed
     */
    public function create(Object $formData);

    /**
     * @param int $diary_srl
     * @return mixed
     */
    public function getDiary(int $diary_srl);

    /**
     * @return mixed
     */
    public function all();

    /**
     * @param int $user_srl
     * @return mixed
     */
    public function userDiary(int $user_srl);


    /**
     * @param Object $formData
     * @param $diary_srl
     * @return mixed
     */
    public function update(Object $formData, $diary_srl): void;
}
