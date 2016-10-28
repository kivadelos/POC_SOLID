<?php

interface ShapeInterface {
    public function area();
}

interface SolidShapeInterface
{
    public function volumen();
}



Class Circle implements ShapeInterface
{
    public $radius;

    public function __construct($radius) 
    {
        $this->radius = $radius;
    }
    public function area()
    {
        return 3.14  * pow ($this->radius, 2);
    }
}

Class Square implements ShapeInterface
{
    public $length;

    public function __construct($length) 
    {
        $this->length = $length;
    }
    public function area()
    {
        return pow($this->length,2);
    }
}

Class cube implements ShapeInterface, SolidShapeInterface
{
    public $length;

    public function __construct($length) 
    {
        $this->length = $length;
    }
    public function area()
    {
        return 6*pow($this->length,1);
    }
    public function volumen()
    {
        return pow($this->length,3);
    }

}
class AreaCalculator
{
    protected $shapes;

    public function __construct($shapes = array())
    {
        $this->shapes = $shapes;
    }
    
    public function sum()
    {
        foreach ($this->shapes as $shape)
        {
            if($shape instanceof ShapeInterface)
            {
                $area[]=$shape->area();
            continue;
        }
        throw new AreaCalculatorInvalidShapeException;
        }
        return array_sum($area);
    }
}
class VolumeCalculator extends AreaCalculator
{
    public function __construct($shapes = array())
    {
        parent::__construct($shapes);
    }
    public function sum()
    {
            //var_dump($this->shapes);
            foreach ($this->shapes as $shape)
            {      
                //echo ($shape instanceof SolidShapeInterface);          
                if($shape instanceof SolidShapeInterface)
                {                    
                    $volumen[]=$shape->volumen();
                    continue;
                }
            throw new VolumenCalculatorInvalidShapeException;
            }
            return array_sum($volumen);     
    }
}


class SumCalculatorOutputter {
    protected $calculator;
    protected $msg;
    public function __construct(AreaCalculator $calculator)
    {
        $this->calculator=$calculator;
    }
    public function toJson()
    {
        $data= array(
            'sum' => $this->calculator->sum()
            );

        return json_encode($data);
    }
    public function toHtml()
    {
        return implode('', array(
            '<hl>',
            '<br>',
            '<br>',
                'Suma de las areas de las figuras: ',
                $this->calculator->sum(),
            '</hl>'
        ));
    }
}    

///////////////////////////   
$shapes = array (
    new Circle(3),
    new Square(4),
    new cube(1)
);
$areas = new AreaCalculator($shapes);
$output = new SumCalculatorOutputter($areas);
echo $output->toJson();
echo $output->toHtml();


$shapes = array (
    new cube(1),    
    new cube(2)
);
$volumen = new VolumeCalculator($shapes);
$output = new SumCalculatorOutputter($volumen);
echo $output->toJson();
echo $output->toHtml();

//echo $shapes[2]->VolumeCalculator();
?>


