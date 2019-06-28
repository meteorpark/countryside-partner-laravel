<?php


namespace App\Traits;

use App\Models\Sns;
use Carbon\Carbon;
use DB;

/**
 * Trait SnsCrawler
 * @package App\Traits
 */
trait SnsCrawler
{

    /**
     * @var string
     */
    private $sns_type_naver_blog = "naverblog";
    /**
     * @var string
     */
    private $sns_type_twitter = "twitter";


    /**
     * @param array $timelines
     */
    public function crawlerTwitter(array $timelines) : void
    {
        $twitter = [];
        foreach ($timelines as $timeline) {
            $twitter['text'] = $timeline['text'];
            $twitter['url'] = $timeline['entities']['urls'][0]['url'];
            $twitter['text_created_at'] = Carbon::parse($timeline['created_at'])->format('Y-m-d H:i:s');
            $this->createSns($twitter, $this->sns_type_twitter);
        }

        $this->keepContentFresh($this->sns_type_naver_blog);
    }
    
    /**
     * @param \SimpleXMLElement $xml
     */
    public function crawlerNaverBlog(\SimpleXMLElement $xml) : void
    {
        $i = 0;
        $naver_blog = [];
        foreach ($xml->channel->item as $item) {
            $naver_blog['text'] = (string)strip_tags($item->description);
            $naver_blog['url'] = (string)$item->link;
            $naver_blog['text_created_at'] = (string)Carbon::parse($item->pubDate)->format('Y-m-d H:i:s');
            $this->createSns($naver_blog, $this->sns_type_naver_blog);

            if ($i > 4) {
                break;
            }

            $i++;
        }

        $this->keepContentFresh($this->sns_type_naver_blog);
    }


    /**
     * @param array $data
     * @param string $sns_type
     */
    public function createSns(array $data, string $sns_type) : void
    {
        Sns::updateOrCreate(
            [
                'sns_type' => $sns_type,
                'url' => $data['url'],
                'text' => $data['text'],
                'text_created_at' => $data['text_created_at'],
            ],
            [
                'sns_type' => $sns_type,
                'url' => $data['url'],
                'text' => $data['text'],
                'text_created_at' => $data['text_created_at'],
            ]
        );
    }


    /**
     * 최신 N개만 유지하기
     * @param string $sns_type
     */
    public function keepContentFresh(string $sns_type) : void
    {
        $deleteIds = [];
        Sns::where('sns_type', $sns_type)
            ->latest('text_created_at')
            ->skip(4)
            ->take(PHP_INT_MAX)
            ->get()
            ->each(function ($row) use (&$deleteIds) {
                $deleteIds[] = $row->id;
            });
        Sns::whereIn('id', $deleteIds)->delete();
    }
}
