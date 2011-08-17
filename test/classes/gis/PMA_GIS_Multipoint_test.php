<?php
/**
 * Test for PMA_GIS_Multipoint
 *
 * @package phpMyAdmin-test
 */

require_once 'PMA_GIS_Geometry_test.php';
require_once 'libraries/gis/pma_gis_geometry.php';
require_once 'libraries/gis/pma_gis_multipoint.php';

/**
 * Tests for PMA_GIS_Multipoint class
 */
class PMA_GIS_MultipointTest extends PMA_GIS_GeometryTest
{
    /**
     * @var    PMA_GIS_Multipoint
     * @access protected
     */
    protected $object;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     *
     * @access protected
     * @return nothing
     */
    protected function setUp()
    {
        $this->object = PMA_GIS_Multipoint::singleton();
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     *
     * @access protected
     * @return nothing
     */
    protected function tearDown()
    {
        unset($this->object);
    }

    /**
     * data provider for testGenerateWkt
     *
     * @return data for testGenerateWkt
     */
    public function providerForTestGenerateWkt()
    {
        $gis_data1 = array(
            0 => array(
                'MULTIPOINT' => array(
                    'no_of_points' => 2,
                    0 => array(
                        'x' => 5.02,
                        'y' => 8.45
                    ),
                    1 => array(
                        'x' => 1.56,
                        'y' => 4.36
                    )
                )
            )
        );

        $gis_data2 = $gis_data1;
        $gis_data2[0]['MULTIPOINT']['no_of_points'] = -1;

        return array(
            array(
                $gis_data1,
                0,
                null,
                'MULTIPOINT(5.02 8.45,1.56 4.36)'
            ),
            array(
                $gis_data2,
                0,
                null,
                'MULTIPOINT(5.02 8.45)'
            )
        );
    }

    /**
     * test getShape method
     *
     * @return nothing
     */
    public function testGetShape()
    {
        $gis_data = array(
            'numpoints' => 2,
            'points' => array(
                0 => array('x' => 5.02, 'y' => 8.45),
                1 => array('x' => 6.14, 'y' => 0.15)
            )
        );

        $this->assertEquals(
            $this->object->getShape($gis_data),
            'MULTIPOINT(5.02 8.45,6.14 0.15)'
        );
    }

    /**
     * data provider for testGenerateParams
     *
     * @return data for testGenerateParams
     */
    public function providerForTestGenerateParams()
    {
        $temp1 = array(
            'MULTIPOINT' => array(
                'no_of_points' => 2,
                0 => array('x' => '5.02', 'y' => '8.45'),
                1 => array('x' => '6.14', 'y' => '0.15')
            )
        );
        $temp2 = $temp1;
        $temp2['gis_type'] = 'MULTIPOINT';

        return array(
            array(
                "'MULTIPOINT(5.02 8.45,6.14 0.15)',124",
                null,
                array(
                    'srid' => '124',
                    0 => $temp1
                )
            ),
            array(
                'MULTIPOINT(5.02 8.45,6.14 0.15)',
                2,
                array(
                    2 => $temp2
                )
            )
        );
    }
}
?>