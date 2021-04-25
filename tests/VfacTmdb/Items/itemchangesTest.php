<?php

namespace VfacTmdb\Items;

use PHPUnit\Framework\TestCase;
use VfacTmdb\lib\Guzzle\Client as HttpClient;

class ItemChangesTest extends TestCase
{
    protected $tmdb         = null;
    protected $movie_id     = 122095;
    protected $tv_id        = 45831;
    protected $tvseason_id  = 3624;
    protected $tvepisode_id = 63056;
    protected $people_id    = 3060721;

    public function setUp() : void
    {
        parent::setUp();

        $this->tmdb = $this->getMockBuilder(\VfacTmdb\Tmdb::class)
                ->setConstructorArgs(array('fake_api_key', 3, new \Monolog\Logger('Tmdb', [new \Monolog\Handler\StreamHandler('logs/unittest.log')]), new HttpClient(new \GuzzleHttp\Client())))
                ->setMethods(['sendRequest', 'getConfiguration'])
                ->getMock();
    }

    public function tearDown() : void
    {
        parent::tearDown();

        $this->tmdb = null;
    }

    /**
     * @test
     */
    public function testMovieItemChangesValid()
    {
        $movie = new Movie($this->tmdb, $this->movie_id);

        $json_object = json_decode(file_get_contents('tests/json/itemChangesMovieOk.json'));
        $this->tmdb->method('sendRequest')->willReturn($json_object);

        $itemChanges = $movie->getChanges();

        $this->assertEquals('/3/movie/'.$this->movie_id.'/changes', parse_url($this->tmdb->url, PHP_URL_PATH));

        $this->assertInstanceOf(\Generator::class, $itemChanges);
        $this->assertInstanceOf(\Vfactmdb\Results\ItemChange::class, $itemChanges->current());

        return $movie->getItemChanges();
    }

    /**
     * @test
     */
    public function testMovieItemChangesEmptyValid()
    {
        $json_object = json_decode(file_get_contents('tests/json/itemChangesMovieEmptyOk.json'));
        $this->tmdb->method('sendRequest')->willReturn($json_object);

        $itemChanges = new MovieItemChanges($this->tmdb, $this->movie_id);
        $changes = $itemChanges->getChanges(array('start_date' => '2000-01-01', 'end_date' => '2000-01-02'));

        $this->assertInstanceOf(\Generator::class, $changes);
        $this->assertNull($changes->current());
    }

    /**
     * @test
     */
    public function testTVShowItemChangesValid()
    {
        $tvshow = new TVShow($this->tmdb, $this->tv_id);

        $json_object = json_decode(file_get_contents('tests/json/itemChangesTVShowOk.json'));
        $this->tmdb->method('sendRequest')->willReturn($json_object);

        $itemChanges = $tvshow->getChanges();

        $this->assertEquals('/3/tv/'.$this->tv_id.'/changes', parse_url($this->tmdb->url, PHP_URL_PATH));

        $this->assertInstanceOf(\Generator::class, $itemChanges);
        $this->assertInstanceOf(\Vfactmdb\Results\ItemChange::class, $itemChanges->current());
    }

    /**
     * @test
     */
    public function testTVShowItemChangesEmptyValid()
    {
        $json_object = json_decode(file_get_contents('tests/json/itemChangesTVShowEmptyOk.json'));
        $this->tmdb->method('sendRequest')->willReturn($json_object);

        $itemChanges = new TVShowItemChanges($this->tmdb, $this->tv_id);
        $changes = $itemChanges->getChanges(array('start_date' => '2000-01-01', 'end_date' => '2000-01-02'));

        $this->assertInstanceOf(\Generator::class, $changes);
        $this->assertNull($changes->current());
    }

    /**
     * @test
     */
    public function testTVShowItemChangesGetSeasonChangesValid()
    {
        $tvshow_itemchanges_json_object = json_decode(file_get_contents('tests/json/itemChangesTVShowWithSeasonChangesOk.json'));
        $tvseason_itemchanges_json_object = json_decode(file_get_contents('tests/json/itemChangesTVSeasonOk.json'));
        $this->tmdb->method('sendRequest')->willReturn($tvshow_itemchanges_json_object, $tvseason_itemchanges_json_object);

        $itemChanges = new TVShowItemChanges($this->tmdb, $this->tv_id);
        $seasonItemChanges = $itemChanges->getSeasonChanges();

        $this->assertEquals('/3/tv/season/'.$this->tvseason_id.'/changes', parse_url($this->tmdb->url, PHP_URL_PATH));

        $this->assertInstanceOf(\AppendIterator::class, $seasonItemChanges);
        $this->assertInstanceOf(\Vfactmdb\Results\ItemChange::class, $seasonItemChanges->current());
    }

    /**
     * @test
     */
    public function testTVShowItemChangesGetSeasonChangesEmptyValid()
    {
        $tvshow_itemchanges_json_object = json_decode(file_get_contents('tests/json/itemChangesTVShowWithSeasonChangesOk.json'));
        $tvseason_itemchanges_json_object = json_decode(file_get_contents('tests/json/itemChangesTVSeasonEmptyOk.json'));
        $this->tmdb->method('sendRequest')->willReturn($tvshow_itemchanges_json_object, $tvseason_itemchanges_json_object);

        $itemChanges = new TVShowItemChanges($this->tmdb, $this->tv_id);
        $seasonItemChanges = $itemChanges->getSeasonChanges();

        $this->assertInstanceOf(\AppendIterator::class, $seasonItemChanges);
        $this->assertNull($seasonItemChanges->current());
    }

    /**
     * @test
     */
    public function testTVShowItemChangesGetEpisodeChangesValid()
    {
        $tvshow_itemchanges_json_object = json_decode(file_get_contents('tests/json/itemChangesTVShowWithSeasonChangesOk.json'));
        $tvseason_itemchanges_json_object = json_decode(file_get_contents('tests/json/itemChangesTVSeasonWithEpisodeChangesOk.json'));
        $tvepisode_itemchanges_json_object = json_decode(file_get_contents('tests/json/itemChangesTVEpisodeOk.json'));
        $this->tmdb->method('sendRequest')
            ->willReturn($tvshow_itemchanges_json_object, $tvseason_itemchanges_json_object, $tvepisode_itemchanges_json_object);

        $itemChanges = new TVShowItemChanges($this->tmdb, $this->tv_id);
        $episodeItemChanges = $itemChanges->getEpisodeChanges();

        $this->assertEquals('/3/tv/episode/'.$this->tvepisode_id.'/changes', parse_url($this->tmdb->url, PHP_URL_PATH));

        $this->assertInstanceOf(\AppendIterator::class, $episodeItemChanges);
        $this->assertInstanceOf(\Vfactmdb\Results\ItemChange::class, $episodeItemChanges->current());
    }

    /**
     * @test
     */
    public function testTVShowItemChangesGetEpisodeChangesEmptyValid()
    {
        $tvshow_itemchanges_json_object = json_decode(file_get_contents('tests/json/itemChangesTVShowWithSeasonChangesOk.json'));
        $tvseason_itemchanges_json_object = json_decode(file_get_contents('tests/json/itemChangesTVSeasonWithEpisodeChangesOk.json'));
        $tvepisode_itemchanges_json_object = json_decode(file_get_contents('tests/json/itemChangesTVEpisodeEmptyOk.json'));
        $this->tmdb->method('sendRequest')
            ->willReturn($tvshow_itemchanges_json_object, $tvseason_itemchanges_json_object, $tvepisode_itemchanges_json_object);

        $itemChanges = new TVShowItemChanges($this->tmdb, $this->tv_id);
        $seasonItemChanges = $itemChanges->getEpisodeChanges();

        $this->assertInstanceOf(\AppendIterator::class, $seasonItemChanges);
        $this->assertNull($seasonItemChanges->current());
    }

    /**
     * @test
     */
    public function testTVSeasonItemChangesValid()
    {
        $tvseason_json_object = json_decode(file_get_contents('tests/json/TVSeasonOk.json'));
        $itemchanges_json_object = json_decode(file_get_contents('tests/json/itemChangesTVSeasonOk.json'));
        $this->tmdb->method('sendRequest')->willReturn($tvseason_json_object, $itemchanges_json_object);

        $tvseason = new TVSeason($this->tmdb, $this->tv_id, 1);
        $itemChanges = $tvseason->getChanges();

        $this->assertEquals('/3/tv/season/'.$this->tvseason_id.'/changes', parse_url($this->tmdb->url, PHP_URL_PATH));

        $this->assertInstanceOf(\Generator::class, $itemChanges);
        $this->assertInstanceOf(\Vfactmdb\Results\ItemChange::class, $itemChanges->current());
    }

    /**
     * @test
     */
    public function testTVSeasonItemChangesEmptyValid()
    {
        $json_object = json_decode(file_get_contents('tests/json/itemChangesTVSeasonEmptyOk.json'));
        $this->tmdb->method('sendRequest')->willReturn($json_object);

        $itemChanges = new TVSeasonItemChanges($this->tmdb, $this->tvseason_id);
        $changes = $itemChanges->getChanges(array('start_date' => '2000-01-01', 'end_date' => '2000-01-02'));

        $this->assertInstanceOf(\Generator::class, $changes);
        $this->assertNull($changes->current());
    }

    /**
     * @test
     */
    public function testTVEpisodeItemChangesValid()
    {
        $tvepisode_json_object = json_decode(file_get_contents('tests/json/TVEpisodeOk.json'));
        $itemchanges_json_object = json_decode(file_get_contents('tests/json/itemChangesTVEpisodeOk.json'));
        $this->tmdb->method('sendRequest')->willReturn($tvepisode_json_object, $itemchanges_json_object);

        $tvseason = new TVEpisode($this->tmdb, $this->tv_id, 1, 1);
        $itemChanges = $tvseason->getChanges();

        $this->assertEquals('/3/tv/episode/'.$this->tvepisode_id.'/changes', parse_url($this->tmdb->url, PHP_URL_PATH));

        $this->assertInstanceOf(\Generator::class, $itemChanges);
        $this->assertInstanceOf(\Vfactmdb\Results\ItemChange::class, $itemChanges->current());
    }

    /**
     * @test
     */
    public function testTVEpisodeItemChangesEmptyValid()
    {
        $json_object = json_decode(file_get_contents('tests/json/itemChangesTVEpisodeEmptyOk.json'));
        $this->tmdb->method('sendRequest')->willReturn($json_object);

        $itemChanges = new TVEpisodeItemChanges($this->tmdb, $this->tvepisode_id);
        $changes = $itemChanges->getChanges(array('start_date' => '2000-01-01', 'end_date' => '2000-01-02'));

        $this->assertInstanceOf(\Generator::class, $changes);
        $this->assertNull($changes->current());
    }

    /**
     * @test
     */
    public function testPeopleItemChangesValid()
    {
        $json_object = json_decode(file_get_contents('tests/json/itemChangesPeopleOk.json'));
        $this->tmdb->method('sendRequest')->willReturn($json_object);

        $people = new People($this->tmdb, $this->people_id);
        $itemChanges = $people->getChanges();

        $this->assertEquals('/3/person/'.$this->people_id.'/changes', parse_url($this->tmdb->url, PHP_URL_PATH));

        $this->assertInstanceOf(\Generator::class, $itemChanges);
        $this->assertInstanceOf(\Vfactmdb\Results\ItemChange::class, $itemChanges->current());
    }

    /**
     * @test
     */
    public function testPeopleItemChangesEmptyValid()
    {
        $json_object = json_decode(file_get_contents('tests/json/itemChangesPeopleEmptyOk.json'));
        $this->tmdb->method('sendRequest')->willReturn($json_object);

        $itemChanges = new PeopleItemChanges($this->tmdb, $this->people_id);
        $changes = $itemChanges->getChanges(array('start_date' => '2000-01-01', 'end_date' => '2000-01-02'));

        $this->assertInstanceOf(\Generator::class, $changes);
        $this->assertNull($changes->current());
    }

    /**
     * @test
     */
    public function testMovieItemChangesInvalidDate()
    {
        $this->expectException(\VfacTmdb\Exceptions\TmdbException::class);
        new MovieItemChanges($this->tmdb, $this->movie_id, array('start_date' => '2020-02-30', 'end_date' => '2020-02-31'));
    }

    /**
     * @test
     */
    public function testTVShowItemChangesInvalidDate()
    {
        $this->expectException(\VfacTmdb\Exceptions\TmdbException::class);
        new TVShowItemChanges($this->tmdb, $this->movie_id, array('start_date' => '2020-02-30', 'end_date' => '2020-02-31'));
    }

    /**
     * @test
     */
    public function testTVSeasonItemChangesInvalidDate()
    {
        $this->expectException(\VfacTmdb\Exceptions\TmdbException::class);
        new TVSeasonItemChanges($this->tmdb, $this->movie_id, array('start_date' => '2020-02-30', 'end_date' => '2020-02-31'));
    }

    /**
     * @test
     */
    public function testTVEpisodeItemChangesInvalidDate()
    {
        $this->expectException(\VfacTmdb\Exceptions\TmdbException::class);
        new TVEpisodeItemChanges($this->tmdb, $this->movie_id, array('start_date' => '2020-02-30', 'end_date' => '2020-02-31'));
    }

    /**
     * @test
     */
    public function testPeopleItemChangesInvalidDate()
    {
        $this->expectException(\VfacTmdb\Exceptions\TmdbException::class);
        new PeopleItemChanges($this->tmdb, $this->movie_id, array('start_date' => '2020-02-30', 'end_date' => '2020-02-31'));
    }

    /**
     * @test
     * @depends testMovieItemChangesValid
     */
    public function testItemChangesGetByKey($itemChanges)
    {
        $changesByKey = $itemChanges->getChangesByKey('crew');
        $itemChange = $changesByKey->current();

        $this->assertInstanceOf(\Generator::class, $changesByKey);
        $this->assertInstanceOf(\Vfactmdb\Results\ItemChange::class, $itemChange);

        $this->assertEquals('607f6ed566f2d2006d3653dc', $itemChange->getId());
    }

    /**
     * @test
     * @depends testMovieItemChangesValid
     */
    public function testItemChangesGetChangeKeys($itemChanges)
    {
        $changeKeys = $itemChanges->getChangeKeys();

        $this->assertIsArray($changeKeys);

        $this->assertEquals('crew', $changeKeys[0]);
    }
}
