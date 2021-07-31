<div class="m-2 border-solid border-green-500 border-4 rounded-2xl box-border h-auto bg-green-300">
    <!-- Waste no more time arguing what a good man should be, be one. - Marcus Aurelius -->
    <div class="m-2 p-2">{!!$msg!!}</div>
    <p class="text-4xl m-2">
        Расстановка приоритетов
    </p>
    @if($seconDeal)
   
        
        <div class ="h-auto hover:bg-yellow-200 border-solid border-green-500 border-4 rounded-2xl box-border m-2  bg-green-100">
            <x-deal-comp :deal="$firstDeal" :category="$category" ></x-deal-comp>
            <form method="post" class="flex justify-center ">    
                @csrf
                <button 
                    formaction="{{route('voteStore',['winDeal'=>$firstDeal, 'loserDeal'=>$seconDeal,'category'=>$category,'mode'=>$mode])}}" 
                    class ="cursor-pointer border-2 border-green-500 border-solid  p-1 rounded-lg bg-red-300  h-8 w-auto ">
                    Важнее это!
                </button>
            </form>
        </div>
        
        <div class ="h-auto hover:bg-yellow-200 border-solid border-green-500 border-4 rounded-2xl box-border m-2 bg-green-100" >
            <x-deal-comp :deal="$seconDeal" :category="$category"></x-deal-comp>
            <form method="post" class="flex justify-center ">  
                @csrf
                <button 
                    formaction="{{route('voteStore',['winDeal'=>$seconDeal, 'loserDeal'=>$firstDeal,'category'=>$category,'mode'=>$mode])}}" 
                    class ="cursor-pointer border-2 border-green-500 border-solid  p-1 rounded-lg bg-red-300  h-8 w-auto flex justify-center ">
                    Важнее это!
                </button>
            </form>
        </div>
        
        
            
        
            
        
    @else
        
        <h1 class="m-2"> Вы расставили все приоритеты.</h1>
    @endif
    
