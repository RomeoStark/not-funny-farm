<?php
abstract class FarmAnimal{
    public int $id;
    public string $productType;
    public function __construct()
    {
        $this->setProductType();
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    abstract public function returnAnimalType();
    abstract public function setProductType();
    abstract public function produce();
}

class Cow extends FarmAnimal{

    public function returnAnimalType(): string
    {
        return 'Корова';
    }

    public function setProductType()
    {
        $this->productType = 'молоко';
    }

    public function produce(): int
    {
        return rand(8, 12);
    }
}

class Chicken extends FarmAnimal{
    public function returnAnimalType(): string
    {
        return 'Курица';
    }

    public function setProductType()
    {
        $this->productType = 'яйцо';
    }

    public function produce(): int
    {
        return rand(0, 1);
    }
}

class Farm{

    public array $barn;
    public array $storage;

    public function barnInfo()
    {
        if(!empty($this->barn))
        {
            echo 'В хлеву: '.PHP_EOL;
            foreach($this->barn as $animalType=>$animal)
            {
                echo count($animal).' ед. '.$animalType.PHP_EOL;
            }
        }
    }
    public function addAnimal(FarmAnimal $animal)
    {
        $this->prepareBarnSection($animal->returnAnimalType());
        $newId = count($this->barn[$animal->returnAnimalType()]) + 1;
        $animal->setId($newId);
        $this->barn[$animal->returnAnimalType()][] = $animal;
        echo 'В хлев добавлено новое животное: '.$animal->returnAnimalType().'. Присвоен идентификатор '.$animal->returnAnimalType().' №'.$newId.PHP_EOL;
    }

    public function dailyCollect()
    {
        foreach($this->barn as $animalType=>$farmAnimal){
            foreach($farmAnimal as $fa){
                $this->prepareStorageSection($fa->productType);
                $productAmount = $fa->produce();
                $animalType.' #'.$fa->id.' произвела '.$productAmount.' ед. продукции'.PHP_EOL;
                $this->storage[$fa->productType] += $productAmount;
            }
        }

    }

    public function weeklyCollect()
    {
        for($i = 1; $i <= 7; $i++){
            $this->dailyCollect();
            echo 'За '.$i.'-й день продукция была собрана';
            echo PHP_EOL;
        }
    }

    public function getTotalProductionAmount()
    {
        if(!empty($this->storage)){
            echo 'На складе: '.PHP_EOL;
            foreach($this->storage as $productType=>$amount)
            {
                echo $amount.' ед. продукта '.$productType.PHP_EOL;
            }
        }
    }

    public function prepareStorageSection($productType)
    {
        if(!isset($this->storage[$productType]))
        {
            $this->storage[$productType] = 0;
        }
    }

    public function prepareBarnSection($animalType)
    {
        if(!isset($this->barn[$animalType]))
        {
            $this->barn[$animalType] = [];
        }
    }

}

$farm = new Farm();
for($i = 1; $i < 11; $i++){
    $farm->addAnimal(new Cow());
}

for($c = 1; $c < 21; $c++){
    $farm->addAnimal(new Chicken());
}
$farm->barnInfo();
$farm->weeklyCollect();
$farm->getTotalProductionAmount();

for($nc = 1; $nc <= 5; $nc++){
    $farm->addAnimal(new Chicken());
}

$farm->addAnimal(new Cow());

$farm->barnInfo();
$farm->weeklyCollect();
$farm->getTotalProductionAmount();