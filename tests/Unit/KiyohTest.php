<?php
/**
 * @author JKetelaar
 */

namespace JKetelaar\Kiyoh\Tests\Unit;

use JKetelaar\Kiyoh\Kiyoh;
use PHPUnit\Framework\TestCase;

final class KiyohTest extends TestCase
{
    private $ini;

    const KIYOH_KEY_ENV_KEY = 'KIYOH_KEY';
    const REVIEW_COUNT = 0;

    protected function setUp(): void
    {
        $this->ini = parse_ini_file('.app.ini');
    }

    public function testKiyoh()
    {
        // TODO: This will fail on Pull Requests (@see https://github.com/JKetelaar/PHP-Kiyoh-API/pull/16#issuecomment-562236830)
        $kiyohKey = $this->ini[self::KIYOH_KEY_ENV_KEY];
        $this->assertNotFalse($kiyohKey);

        $kiyoh = new Kiyoh($kiyohKey, self::REVIEW_COUNT);

        $company = $kiyoh->getCompany();
        $this->assertNotNull($company);

        $averageRating = $company->getAverageRating();
        $this->assertGreaterThan(0, $averageRating);

        $reviews = $kiyoh->getCompany()->getReviews();
        $this->assertNotNull($reviews);
        $this->assertEquals(self::REVIEW_COUNT, count($reviews));
    }
}
