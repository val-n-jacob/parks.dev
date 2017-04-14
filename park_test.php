<?php 

require_once 'Park.php';

echo Park::count();


       $parks = Park::all();
       foreach($parks as $park) {
           echo $park->id . PHP_EOL;
           echo $park->name . PHP_EOL;
           echo $park->description . PHP_EOL;
           echo $park->areaInAcres . PHP_EOL;
       }

       $parks = Park::paginate(1, 5);
       foreach($parks as $park) {
           echo $park->id . PHP_EOL;
           echo $park->name . PHP_EOL;
           echo $park->description . PHP_EOL;
           echo $park->areaInAcres . PHP_EOL;
       }
