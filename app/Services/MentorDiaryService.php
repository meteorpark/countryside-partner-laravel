<?php


namespace App\Services;

use App\Models\MentorDiary;

/**
 * Class MentorDiaryService
 * @package App\Services
 */
class MentorDiaryService implements DiaryInterface
{
    /**
     * @var FileUploadService
     */
    private $fileUploadService;
    /**
     * @var MentorDiary
     */
    private $mentorDiary;

    /**
     * MentorDiaryService constructor.
     * @param MentorDiary $mentorDiary
     * @param FileUploadService $fileUploadService
     */
    public function __construct(MentorDiary $mentorDiary, FileUploadService $fileUploadService)
    {
        $this->mentorDiary= $mentorDiary;
        $this->fileUploadService = $fileUploadService;
    }


    /**
     * @param $diaryData
     */
    public function create(Object $diaryData)
    {
        $this->mentorDiary->mentor_srl  = $diaryData->id;
        $this->mentorDiary->title       = $diaryData->title;
        $this->mentorDiary->contents    = $diaryData->contents;
        $this->mentorDiary->image       = $this->fileUploadService->uploadContent($diaryData->image);
        $this->mentorDiary->save();
    }

    /**
     * @param $diary_srl
     * @return MentorDiary|MentorDiary[]|\Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model|null
     */
    public function getDiary(int $diary_srl)
    {
        return $this->mentorDiary->with('mentor')->find($diary_srl);
    }

    /**
     * @return MentorDiary[]|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public function all()
    {
        return $this->mentorDiary->with('mentor')->orderBy('regdate', 'desc')->get();
    }

    /**
     * @param $mentor_srl
     * @return \Illuminate\Support\Collection
     */
    public function userDiary(int $mentor_srl)
    {
        // TODO: Implement userDiary() method.
        $mentorDiaries = $this->mentorDiary->where('mentor_srl', $mentor_srl)->orderBy('regdate', 'DESC')->paginate(15);
        $collection = collect($mentorDiaries);

        $diaries = $collection->map(function ($item, $key) {
            if ($key === "data") {
                for ($i = 0; $i < count($item); $i++) {
                    $item[$i]['contents'] = str_limit($item[$i]['contents'], $limit = 200, $end = '...');
                }
            }

            return $item;
        });

        return $diaries;
    }


    /**
     * @param Object $diaryData
     * @param $diary_srl
     * @return mixed|void
     */
    public function update(Object $diaryData, $diary_srl): void
    {
        $diary = $this->mentorDiary->find($diary_srl);
        $diary->title = $diaryData->title;
        $diary->contents = $diaryData->contents;

        if (filter_var($diaryData->deleteImage, FILTER_VALIDATE_BOOLEAN) === true) {
            $diary->image = "";
        }

        $image = $this->fileUploadService->uploadContent($diaryData->image);
        empty($image) ? : $diary->image = $image;

        $diary->save();
    }

    public function destroy(int $diary_srl)
    {
        // TODO: Implement destroy() method.
    }
}
