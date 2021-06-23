<?php

use App\Models\Deal;
use App\Models\Category;
use Illuminate\Support\Facades\DB;

/*
 * подсчитывает количество строк в таблице БД
 */
function count_hits($user){//Проверяем количество записей в БД
    
    $query =  "select COUNT(*) from general WHERE user = '$user'";
    
    $result = mysql_query($query);
    $q = mysql_fetch_row($result); 
    $q=(integer)$q[0];
    dd('function count_hits($user)');
    return $q;
}
function historyToStr($arr){
   
  
    $resStr = implode(',', $arr);
    
    return $resStr;
}
function getPare($id_history,$pos, $del_id){
    global $history_matr;


    //Идентификатор истории первого хита, в которой находится запись о втором хите пары
    $id1=$id_history;
    //Позиция записи о втором хите в истории первого хита пары
    $pos2in1 = $pos;
    
    
    //Идентификатор истории второго хита пары,  в которой находится запись о первом хите пары  
    $id2=$history_matr[$id1]['history'][$pos]['pare_id'];
    //Рейтинг до позиции второго хита в истории первого хита пары (рейтинг первого элемента пары)
    //$rating1 = getReting($id1, $id2);
    //$history_matr[$id1]['rating'] = $rating1;
        

    if(!isset($history_matr[$id2])) {
        $history_matr[$id2]['history'] = getHistory ($id2); 
           
        $history_matr[$id2]['pos'] = 0;
    }   

      // частота появления второго хита в истории первого хита
        $freq2in1 = getFrequency($id2, $id1, $pos);
        // частота появления первого хита в истории второго хита
        $freq1in2 = $freq2in1;//!!!!здесь может возникнуть рассогласвание позиций        
        
    //Позиция записи о первом хите в истории второго хита пары должна быть на 1 больше хранимого в этом поле значения
    $pos1in2 = findParePos($history_matr[$id2]['history'], $id1, $freq2in1);
    
    if($pos1in2!==NULL){
        /*

        if (isset($history_matr[$id2]['pos'])){
            if($pos1in2 - $history_matr[$id2]['pos']>1 && $history_matr[$id2]['freq'][$id1]>1){
                echo '$pos1in2 - $history_matr[$id2]["pos"]>1';
                echo '$pos1in2 - $history_matr[$id2]["pos"] = '.($pos1in2 - $history_matr[$id2]["pos"]);
                exit();
            }

        }*/
        if($pos1in2>$history_matr[$id2]['pos']){
            $history_matr[$id2]['pos']= $pos1in2;
        }

        //Рейтинг до позиции первого  хита в истории второго хита пары (рейтинг второго хита)
        //$rating2 = getReting( $id2, $id1);
        //$history_matr[$id2]['rating']=$rating2;

        //результат голосования в этой паре
        if($history_matr[$id1]['history'][$pos2in1]['pare_chang'] < 0){
            $sa1=1;
            $sa2=0;
        }
        else{
            $sa1=0;
            $sa2=1;
        }

        $node[$id1]=array('pos'=>$pos2in1,'freq'=>$freq2in1,'sa'=>$sa1);
        $node[$id2]=array('pos'=>$pos1in2,'freq'=>$freq1in2,'sa'=>$sa2);

        $node = getRating($node,$del_id);



        return $node;
    }
    else{
        return NULL;
    }
    
   
}
/*
 * Ищет в истории  запись о заданном хите $n раз
 */
function findParePos($history,$id_hit,$n){
    echo $id_hit.' $n='.$n;
     for($i=0;$i<sizeof($history);$i++){
              
        if ($history[$i]['pare_id'] == $id_hit){
            $n--;
            if($n==0){
                return $i;
            }
            
        }
     }
     var_dump($history);
     echo '<br>something had go no right in findParePos<br>';
     return NULL;
}
function getStartPare($id_del,$pos){
    $del_history_arr = getHistory($id_del);//строка истории удаляемого хита в виде массива
    
    $pare_items1=  explode(':', $del_history_arr[$pos]);//первый элемент пары - первый элемент строки истории удаляемого массива
    $pare_id1 = $pare_items1[0];//id первого элемента пары
    
    
    $history_arr2 =  getHistory($pare_id1);//строка истории второго элемента пары в виде  массива.
    
    
    //Находим среди элементов истории первого элемента пары парный элемент к первому элементу истории удаляемого  хита.
    //Он дожен иметь идентификатор соответствующий идентификатору удаляемого хита 
    for($i=0;$i<sizeof($history_arr2);$i++){
        $pare_items2 = explode(':', $history_arr2[$i]);
        
        if ($pare_items2[0] == $id_del){
            $pos2 = $i;
            break;
        }
        
    }
    //поле "история" содержит историю парного элемента к самому элементу,а не самого элемента.
    $res_arr[$id_del]['history'] = $history_arr2;
    $res_arr[$pare_id1]['history'] = $del_history_arr;    
    $res_arr[$pare_id1]['pos'] = 0;  
    $res_arr[$id_del]['pos'] = $pos2;
    $res_arr[$pare_id1]['rating'] = getRating($res_arr[$id_del]);
    $res_arr[$id_del]['rating'] = getRating($res_arr[$pare_id1]);
     
    return $res_arr;   
    
}
function getStartPare_($id_del,$pos){
    $del_history_arr = getHistory($id_del);//строка истории удаляемого хита в виде массива
    
    $pare_items1=  explode(':', $del_history_arr[$pos]);//первый элемент пары - первый элемент строки истории удаляемого массива
    $pare_id1 = $pare_items1[0];//id первого элемента пары
    
    
    $history_arr2 =  getHistory($pare_id1);//строка истории второго элемента пары в виде  массива.
    
    
    //Находим среди элементов истории первого элемента пары парный элемент к первому элементу истории удаляемого  хита.
    //Он дожен иметь идентификатор соответствующий идентификатору удаляемого хита 
    for($i=0;$i<sizeof($history_arr2);$i++){
        $pare_items2 = explode(':', $history_arr2[$i]);
        
        if ($pare_items2[0] == $id_del){
            $pos2 = $i;
            break;
        }
        
    }
    //поле "история" содержит историю парного элемента к самому элементу,а не самого элемента.
    $res_arr[$id_del]['history'] = $history_arr2;
    $res_arr[$pare_id1]['history'] = $del_history_arr;    
    $res_arr[$pare_id1]['pos'] = 0;  
    $res_arr[$id_del]['pos'] = $pos2;
    $res_arr[$pare_id1]['rating'] = getRating($res_arr[$id_del]);
    $res_arr[$id_del]['rating'] = getRating($res_arr[$pare_id1]);
     
    return $res_arr;   
    
}
function getStartPare_1($id_del){
    $del_history_arr = getHistory($id_del);//строка истории удаляемого хита в виде массива
    
    $pare_items1=  explode(':', $del_history_arr[0]);//первый элемент пары - первый элемент строки истории удаляемого массива
    $pare_id1 = $pare_items1[0];//id первого элемента пары
    $res_arr[1]['history'] = $del_history_arr;
    $res_arr[1]['pos'] = 0;    
    
    $history_arr2 =  getHistory($pare_id1);//строка истории второго элемента пары в виде  массива.
    
    
   
    for($i=0;$i<sizeof($history_arr2);$i++){
        $pare_items2 = explode(':', $history_arr2[$i]);
        
        if ($pare_items2[0] == $id_del){
            $pos2 = $i;
            break;
        }
        
    }
    $res_arr[2]['pos'] = $pos2;
    $res_arr[2]['history'] = $history_arr2;
    $res_arr[1]['id'] = $id_del;
    $res_arr[2]['id'] = $pare_id1;
    return $res_arr;
    
}
/*
 * Функция определения рейтинга элемета пары
 * $pare_item - парный элемент, к тому, для которого считаем рейтинг (а не сам элемент), представляющий собой массив, содержащий историю, и позицию элемента в истории.
 */
function getRating_($pare_item){
    $rating = 500;

    
   
    for($i=0;$i<$pare_item['pos'];$i++){
        $id_and_change = explode(':',  $pare_item['history'][$i]);
        
        $rating += $id_and_change[1];
    }
    return $rating;
    
}
function getNode($pare_arr){
    //$id1 = $pare_arr[1]['id'];
}
function getNode_($pare_arr){
    foreach ($pare_arr as $key => $value){
        $pos = $pare_arr[$key]['pos'];
        $node[$key]['pos']=$pos;
        $history_item = $pare_arr[$key]['history'][$pos];
        $node_items = explode(':', $history_item);
        $node[$key]['change'] = $node_items[1];
        $node[$key]['history'] = $pare_arr[$key]['history'];
        $node_items = explode(':', $node[$key]['history'][$pos+1]);
        if($pos < sizeof($pare_arr[$key]['history'])){
            $node[$key]['child'] = getStartPare($node_items[0],$pos+1);
        }
        else{
            $node[$key]['child'] = NULL;
        }
        
        //var_dump( $node[$key]['child']);
        $node[$key]['rating'] = $pare_arr[$key]['rating'];
    }

    return $node;
    
}
/*
 * 
 */
function addHeap($node,$queue){

    $heap[$pos]=$node;
    return $heap;
}
function findPosInQueue($node, $queue){
    //определяем текущую позицию очереди
    $curPos = key($queue);
    //определяем следующую позицию очереди
    next($queue);
    $nextPos = key($queue);
    if(!$nextPos) $nextPos = $curPos;
    prev($queue);
    foreach ($node as $key => $value) {
        $pos[] = $value[$key]['pos'];
    }
    if($pos[1]>$nextPos){
        $insert_pos = $pos[1];
    }
    else{
        $insert_pos = $pos[0];
    }
    return $insert_pos;
    
}

function addQueue($node,$queue){
    if($node==NULL){
        echo '';
    }
    //определяем текущую позицию очереди
    $curPos = key($queue);
    //определяем следующую позицию очереди
    next($queue);
    $nextPos = key($queue);
    if(!$nextPos) $nextPos = $curPos;
    prev($queue);
    
    foreach ($node as  $value) {
        $pos[] = $value['pos'];
    }
    if($pos[1]>$pos[0]){
        $maxpos = $pos[1];
        $minpos=$pos[0];
    }
    else{
        $maxpos = $pos[0];
        $minpos=$pos[1];
    }
    if($maxpos>$nextPos && $nextPos<>$minpos){
        $insert_pos = $maxpos;
    }
    else{
        $insert_pos = $minpos;
    }
    
    $queue[$insert_pos][] = $node;
    return $queue;
    //$queue[]
}
function findForExtract($heap){
    $min_sum_pos =  sizeof($heap)*2;
    //для каждой пары кучи
    foreach ($heap as $key_node=> $node) {
        $sum_pos=0;
       
        //для каждого элемента пары
        foreach ($node as $key_item => $value) {
 
            $sum_pos +=$value['pos'];
            

            
            
        }
        if($sum_pos <= $min_sum_pos){
            $key_up = $key_node;
        }
        
    }
    
    return $key_up;
}
function extractFromQueue($queue, $poskey, $del_id){
    global $history_matr;
 
    $array_of_nodes_in_first_position = $queue[$poskey];//получаем массив узлов первой позиции очереди
    reset($array_of_nodes_in_first_position);
    $number_of_node = key($array_of_nodes_in_first_position);//получаем узел для удаления (любой узел из первой позиции очереди)
  
   
    $extract_node = $array_of_nodes_in_first_position[$number_of_node];

    //для каждого элемента пары
    foreach ($extract_node as $key => $item) {
            

            //если его позиция в истории не является последней
            if($item['pos']< sizeof($history_matr[$key]['history'])-1 && $item['pos']>=$history_matr[$key]['pos']){
      
                $child = getPare($key, $item['pos']+1,$del_id);//дочерняя пара построенная от следующего элемента истории хита $key
                if($child)  
                $queue =  addQueue($child, $queue);
                //$history_matr[$key]['pos']++;
                


            }
            else {
      
                
            }

        }
    //считываем ключи элементов пары
    //$id[0]-идентификатор первого элемента пары
    //$id[1]-идентификатор второго элемента пары
    foreach ($extract_node as $key => $value) {
        $id[]= $key;
    }
    
    //если ни  один элемент пары не является удаляемым хитом
    if($id[0]!=$del_id && $id[1]!=$del_id){
        
       
        
        //увеличиваем частоту на 1
        //$history_matr[$id[0]]['freq'][$id[1]]=$history_matr[$id[1]]['freq'][$id[0]]=$history_matr[$id[0]]['freq'][$id[1]]+1;
        //перемещаем также соответственно позицию в матрице историй
        //$history_matr[$id[0]]['pos']++;
       // $history_matr[$id[1]]['pos']++;
    }
    else{
        
        //$history_matr[$id[0]]['history'][$history_matr[$id[0]]['pos']]['pare_chang']=0;
        //$history_matr[$id[1]]['history'][$history_matr[$id[1]]['pos']]['pare_chang']=0;
    }

        

   
    
    
    unset($queue[$poskey][$number_of_node]);
   if(sizeof($queue[$poskey])==0){
       unset($queue[$poskey]);
   }
 
    
    return $queue;
    
}


function extractFromHeap($heap,$del_id){
    global $history_matr;
    $key_up = findForExtract($heap);
    $extract_node = $heap[$key_up];

    
    
    foreach ($extract_node as $key => $value) {
        $id[]= $key;
    }
    //если ни  один элемент пары не является удаляемым хитом
    if($id[0]!=$del_id && $id[1]!=$del_id){
    
    }
    else{
       
    }
    //для каждого элемента пары
    foreach ($extract_node as $key => $item) {
        //если его позиция в истории не является последней
        if($extract_node[$key]['pos']< sizeof($history_matr[$key])-1){
            $child[$key] = getPare($id[0], $item['pos']+1);
            $heap[$item['pos']+1]=$child[$key] ;
            
        }
        
    }
    exit();
        unset($heap[$key_up]);
    
}
function getFirstPlacePos($queue) {
    ksort($queue);
    reset($queue);
    return key($queue);
}
/*
 * функция удаления хита из бд по его id
 */
function delete_hit($id_del){
    global $history_matr;
    
    $story = getHistory($id_del);    
    
    if($story){
        //добавляем в матрицу историй истрию удаляемого хита с текущей позицией 0
        $history_matr[$id_del]['history'] = $story;
        $pos=0;
        
        do{
            
            $history_matr[$id_del]['pos'] = $pos;
            $node = getPare($id_del, $pos,$id_del);
            
            $pos++;
        
            
        }while ($node==NULL && $pos < sizeof($history_matr[$id_del]['history']));
        

        //$pare_id = $history_matr[$id_del]['history'][$pos]['pare_id'];
        //$history_matr[$id_del]['freq'][$pare_id] =  getFrequency($pare_id, $id_del);

        //$history_matr[$id_del]['rating'] = getReting($id_del, $id_del);

        



        $queue=array();
        if($node){
        $queue = addQueue($node, $queue);
        
        }
   
        while (sizeof($queue)>0){


            $firstPlacePos = getFirstPlacePos($queue);
            

                $queue=extractFromQueue($queue, $firstPlacePos, $id_del);
               
            


        }
        
        foreach ($history_matr as $keyhistory => $history) {
           
           
            $history_item = '';
            $history_arr_str_item = array();
            $rating =500;
            
            foreach ($history['history'] as $key_history_item => $history_item) {
                if($history_item['pare_id']<>$id_del){
                    $str_history_item[$key_history_item] = implode(':', $history_item);
                    $history_arr_str_item[] = $str_history_item[$key_history_item];
           
                }
                $rating -= $history_item['pare_chang'];
            }
            
            $str_history =  implode(',', $history_arr_str_item);
            $votes = sizeof($history_arr_str_item);
            
        
            
            $query = "UPDATE `deals` SET `votes`=$votes,`rating`=$rating,`history`= '$str_history' WHERE `ID`=$keyhistory";
            echo "$query<br>";//**
            DB::unprepared($query);
        }
    }

    unset($history_matr[$id_del]);
    $query = "DELETE FROM `deals` WHERE `ID` = $id_del";
    DB::unprepared($query);


    
    return;
     
        
    
    
}
function getRating($node, $del_id){
    global $history_matr;

    
    //
    
    foreach ($node as $key => $value) {
        $id[]=$key;
        
        $rating[]=  getReting($key, $del_id);        
        $sa[]=$value['sa'];
        $pos[] = $value['pos'];
        $votes=0;
   
        /*
        foreach ($history_matr[$key]['history'] as $num_pos => $record) {
            
                if($key!=$del_id && $num_pos < $value['pos']){
                    $votes++;
                }
            
            

        }
         */
        for($i=0;$i < $value['pos'];$i++){
            if($history_matr[$key]['history'][$i]['pare_id'] !=$del_id){
                    $votes++;
                }
        }

        $q[]=$votes;

        
    }

    if($id[0]!=$del_id && $id[1]!=$del_id){
        //пересчитываем рейтинги
        $newratig[0] = r_elo($rating[0], $rating[1], $sa[0], $q[0]);
        $newratig[1] = r_elo($rating[1], $rating[0], $sa[1], $q[1]);
    }
    else {
        $newratig[0] = $rating[0];
        $newratig[1] = $rating[1];
    }
        //$history_matr[$id[0]]['rating'] = $node[$id[0]]['rating'] = $newratig[0];
        //$history_matr[$id[1]]['rating'] = $node[$id[1]]['rating']  = $newratig[1];
        
            //пересчитываем изменения рейтингов
        foreach ($newratig as $key => $value) {
            $change_rating = $rating[$key]-$newratig[$key];
            
            $num_pos = $pos[$key];
            
            $history_matr[$id[$key]]['history'][$num_pos]['pare_chang'] = $change_rating;

        }

 
    return $node;
    
    


}


function recount_rating($node, $del_id){
    global $history_matr;

    
    //
    foreach ($node as $key => $value) {
        $id[]=$key;
        $rating[]=$value['rating'];
        $q[]=$value['pos'];
        $sa[]=$value['sa'];

        
    }

    if($id[0]!=$del_id && $id[1]!=$del_id){
        //пересчитываем рейтинги
        $newratig[0] = r_elo($rating[0], $rating[1], $sa[0], $q[0]);
        $newratig[1] = r_elo($rating[1], $rating[0], $sa[1], $q[1]);
    }
    else {
        $newratig[0] = $rating[0];
        $newratig[1] = $rating[1];
    }
        $history_matr[$id[0]]['rating'] = $node[$id[0]]['rating'] = $newratig[0];
        $history_matr[$id[1]]['rating'] = $node[$id[1]]['rating']  = $newratig[1];
        
            //пересчитываем изменения рейтингов
        foreach ($newratig as $key => $value) {
            $change_rating = $rating[$key]-$newratig[$key];
            
            $pos =$q[$key];
            
            $history_matr[$id[$key]]['history'][$pos]['pare_chang'] = $change_rating;

        }

 
    return $node;
    
    


}
/*
 * база
 * массив для пересчета (Двумерный )
 * базовый рейтинг, с которого начинаем пересчет
 */
function recount_rating_($base_id, $pos, $base_rating){
    $arr = array();
    $hit1 = getHit($base_id);//по этому хиту пересчитывае рейтинг и меняем историю
    foreach ($arr_recount as $current){
        $hit2 = getHit($current[0]);//это парный элемент к  $hit1 
        $rating=$hit2->rating;//исходный рейтинг
        $history = getHistory($current[0]);//получаем историю, чтобы в ней найти запись про выбор из $hit1 и $hit2
        //для каждого элемента истории после удаленного
        for($i=sizeof($history)-1;$i>=0;$i--){
            $rating= $rating+ $history[$i][1];
            if($history[$i][0]==$base_id){
                if(isset($arr[$history[$i][0]])){
                    $start = $arr[$history[$i][0]];
                }
                else{
                    $start = 0;
                }
                $arr[$history[$i][0]]=$i;
                $r1=$base_rating;
                $r2= $rating;
                if($current[1]>0){
                    $s1=1;
                    $s2=0;
                }
                else{
                    $s1=0;
                    $s2=1;
                }
                $q1=$hit1->votes-sizeof($arr_recount);
                $q2=$i-1;
                $r_1 = r_elo($r1, $r2, $s1, $q1);
                $r_2 = r_elo($r2, $r1, $s2, $q2);
                break;
            }
        } 
    }
   
    
}
//Ищет частоту появления хита $hit_id в истории $history_id до позиции $pos включительно
//
function getFrequency($hit_id,$history_id, $pos){
    global $history_matr;
 
    if (isset($history_matr[$history_id]['freq'][$hit_id])){
        $history_matr[$history_id]['freq'][$hit_id]++;
    }  else {
        $history_matr[$history_id]['freq'][$hit_id]=0;
        
        
        for($i=0; $i<=$pos;$i++){
            if($history_matr[$history_id]['history'][$i]['pare_id']==$hit_id){
                $history_matr[$history_id]['freq'][$hit_id]++;
            }
        }
        
    }
        



      
   
        
    
    return $history_matr[$history_id]['freq'][$hit_id];
}
/*
function getReting($pos,$history,$del_id){
    
    
    $reting = 500;
    for($i = 0; $i < $pos;$i++){
        if($history['history'][$i]['pare_id'] != $del_id)
        $reting -= $history['history'][$i]['pare_chang'];
    }
    return $reting;
}
 * 
 */

function getReting($history_id, $del_id){
    global $history_matr;
    if(!isset($history_matr[$history_id]['pos'])) $history_matr[$history_id]['pos']=0;
    $pos = $history_matr[$history_id]['pos'];
    $reting = 500;
    for($i = 0; $i < $pos;$i++){
       
        if($history_matr[$history_id]['history'][$i]['pare_id'] != $del_id)
            
        {$reting -= $history_matr[$history_id]['history'][$i]['pare_chang'];}
    }
    //
    return $reting;
}
 

/*
 * Получает из БД историю голосований хита в виде двумерного массива
 * 
 */
function getHistory($id){
    $hit = getHit($id);  
    
    
    $resArr = NULL;
    if($hit->history !=''){
        $votes = explode(',', $hit->history);
        foreach ($votes as $pos => $vote) {
            $vote_items = explode(':', $vote);  
            $resArr[$pos]['pare_id'] = $vote_items[0];
            $resArr[$pos]['pare_chang'] = $vote_items[1];
        }        
    }

    //var_dump($resArr);
    return $resArr;
}
/*
 * Получает объект хита по его идентификатору 
 */
function getHit($id){
    return Deal::find($id);
    
}
//////////////////////////////////////
function r_elo($Ra,$Rb,$Sa,$q){
// $Sa- Если первый игрок выиграл =1, если первый проиграл=0, если ничья =0.5
//$q -количество игр (голосований). Е
//определяем математическое ожидание
$E=1/(1+ pow(10,(($Rb-$Ra)/400)));
//$E=1/(1+ (10*($Rb-$Ra)/400));
 //Определяем коэффициент
 	If($Ra>=2400){
 	 $K=10;
 	 }	 
Else{	 
 $K=15;	 
}//End If


 	If($q<30){
 	 $K=30;
}//End If


$Ra=  round($Ra+$K*($Sa-$E));
 Return $Ra;
}
function findRatingPos($rating, $user_id){
    //формируем запрос на получение числа записей с более высоким рейтингом
    $query = "SELECT COUNT(*) FROM `general` WHERE `user`=$user_id AND rating>$rating";
    //выполняем запрос
    $res = queryRun($query, "error in findRatingPos");
    $row = mysql_fetch_row($res);
    $max = $row[0];
    
    //формируем запрос на получение числа записей с более низким рейтингом
     $query = "SELECT COUNT(*) FROM `general` WHERE `user`=$user_id AND rating = $rating";
     
    //выполняем запрос
    $res = queryRun($query, "error in findRatingPos");
    //формируем и возвращаем строку описывающее место в рейтинге
    $row = mysql_fetch_row($res);
    $equal = $row[0];
    $res_str = "Позиция в рейтинге";
    if($max==0){
        $res_str .= "от 1 до ".(1+$equal);
    }else{
        if($equal > 1){
            $res_str .= ($max+1)." до ".($max+1+$equal);
        }
        else{
            $res_str .= $max+1;
        }
    }
    return $res_str;
}

?>