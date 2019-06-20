<?php


namespace App\Services;

use App\Exceptions\MeteoException;
use App\Models\MenteeDiary;
use App\Traits\JwtTrait;

/**
 * Class MentorDiaryService
 * @package App\Services
 */
class MenteeDiaryService implements DiaryInterface
{
    use JwtTrait;
    /**
     * @var FileUploadService
     */
    private $fileUploadService;

    /**
     * @var MenteeDiary
     */
    private $menteeDiary;

    /**
     * MenteeDiaryService constructor.
     * @param MenteeDiary $menteeDiary
     * @param FileUploadService $fileUploadService
     */
    public function __construct(MenteeDiary $menteeDiary, FileUploadService $fileUploadService)
    {
        $this->menteeDiary= $menteeDiary;
        $this->fileUploadService = $fileUploadService;
    }
    /**
     * @param int $diary_srl
     * @param int $user_id
     * @return mixed
     */
    public function destroy(int $diary_srl, int $mentor_srl): void
    {
        $diary = MenteeDiary::find($diary_srl);

        if ($diary) {
            $diary->delete();
        }
    }

    /**
     * @param Object $diaryData
     * @return mixed
     */
    public function create(Object $diaryData)
    {
        $this->menteeDiary->mentee_srl  = $diaryData->id;
        $this->menteeDiary->title       = $diaryData->title;
        $this->menteeDiary->contents    = $diaryData->contents;
        $this->menteeDiary->image       = $this->fileUploadService->uploadContent($diaryData->image);
        $this->menteeDiary->save();
    }


    /**
     * @param int $diary_srl
     * @return mixed
     * @throws MeteoException
     */
    public function getDiary(int $diary_srl)
    {
        $diary = $this->menteeDiary->with('mentee')->find($diary_srl);

        if ($diary) {
            if ($this->useJwt() === $diary->mentee_srl) {
                $diary->setAttribute('is_owner', true);
            }

            return $diary;
        }

        throw new MeteoException(200);
    }

    /**
     * @return mixed
     */
    public function all()
    {
        // TODO: Implement all() method.
    }

    /**
     * @param int $mentee_srl
     * @return \Illuminate\Support\Collection|mixed
     */
    public function userDiary(int $mentee_srl)
    {
        $menteeDiaries = $this->menteeDiary->where('mentee_srl', $mentee_srl)->orderBy('regdate', 'DESC')->paginate(15);

        $dd =$this->menteeDiary->where('mentee_srl', $mentee_srl)->orderBy('regdate', 'DESC')->toSql();
        echo $dd;


        $collection = collect($menteeDiaries);

        $diaries = $collection->map(function ($item, $key) {
            if ($key === "data") {
                for ($i = 0; $i < count($item); $i++) {
                    $item[$i]['user_type'] = 'mentee';
                    $item[$i]['srl'] = $item[$i]['mentee_srl'];
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
     * @return mixed
     */
    public function update(Object $diaryData, $diary_srl): void
    {
        $diary = $this->menteeDiary->find($diary_srl);
        $diary->title = $diaryData->title;
        $diary->contents = $diaryData->contents;

        if (filter_var($diaryData->deleteImage, FILTER_VALIDATE_BOOLEAN) === true) {
            $diary->image = "";
        }

        $image = $this->fileUploadService->uploadContent($diaryData->image);
        empty($image) ? : $diary->image = $image;

        $diary->save();
    }
}
