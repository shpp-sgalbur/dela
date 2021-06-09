<?php

namespace App\View\Components;

use Illuminate\View\Component;
use App\Models\Deal;
use App\Models\Category;
use Illuminate\Http\Request;

class VoteForm extends Component
{
    public $category;
    public $dealspair=[];
    public $firstDeal;
    public $seconDeal;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($category, Request $request)
    {
        
        $this->category = $category;
        $deals_count = Deal::where('category_id',$category->id)->count();
        if($deals_count > 1){
            //$votes_arr=array();
            $unic_para=false;
            $deals=Deal::where('category_id',$category->id)->orderBy('votes', 'asc')->get();
            for($i = 0; $i <= count($deals)-1; $i++){
                $id1 = $deals[$i]->id;
                for($j = $i+1; $j <= count($deals)-1; $j++){
                    $id2 = $deals[$j]->id;
                    
                    $history1 = $deals[$i]->history;
                    $history1arr = explode(',',$deals[$i]->history);
                    foreach ($history1arr as $secondDeal){
                        $secondDealArr = explode(':',$secondDeal);
                        $secondsDealsArr[$secondDealArr[0]]=$secondDealArr[0];
                    }
                    //dump($secondsDealsArr);
                    if(in_array($id2, $secondsDealsArr)){
                        //dump('Ta dam!!!!!');
                        continue;
                        
                    } 
                    
                    $id="$id1-$id2"; 
                    if(session('votes_arr'.$category->id)){
                        $votes_arr= (session('votes_arr'.$category->id));
                        foreach ($votes_arr as $value){
                            $para_votes=explode("-", $value);
                            $para1 ="$para_votes[0]-$para_votes[1]";   
                            $para2="$para_votes[1]-$para_votes[0]";
                            if ($id!=$para1 & $id!=$para2){
                                $unic_para=true;//голосование
                            }Else{//если предлагаемая пара  голосовалась
                                $unic_para=false;//пара не уникальная	
                                break;//досрочный выход из цикла foreach, чтобы поменять второй элемент пары	 

                            }//end if	
                        }
                    }else{
                        $unic_para=true;
                    }
                    If( $unic_para){//если пара для пользователя  уникальная	 

                        Break; //досрочно выходим из цикла подбора второго элемента пары	 
                    }//end if
                }
                If($unic_para){//если пара для пользователя  уникальная	 

                     Break; //досрочно выходим из цикла подбора первого элемента пары	 
                }//end if
                
            }
            //dump($deals);
             If($i >=($deals_count-2)){
                 $unic_para=false;//пара не уникальная	
             }else{
                 If($unic_para){
                 //session()->push("votes_arr",$id);//перенести в скрипт обработки голосования
                 
                 $this->firstDeal = $deals[$i];
                 $this->seconDeal = $deals[$j];
                 //dd($this->firstDeal);
                 
             }
             }
             
            
            //dump(session('votes_arr'));
           
        }
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('components.vote-form');
    }
}
