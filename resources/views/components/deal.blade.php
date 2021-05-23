<div class="w-auto m-2 order-solid border-2 border-green-500 bg-green-50">
    {{$deal->content}}
    <div class ="flex flex-row   px-2 " >
        <div class="border-2 border-green-500 border-solid ml-3 p-1  bg-green-200 h-8 "><span>Рейтинг:&nbsp;{{$deal->rating}}</span></div>
        <div class="border-2 border-green-500 border-solid ml-3 p-1  bg-green-200 h-8 ">Сравнений:&nbsp;{{$deal->votes}}</div>
        <div class="flex justify-end w-full ">
            <div class ="border-2 border-green-500 border-solid ml-3 p-1 rounded-lg bg-green-200 h-8 w-8">
                <a href="{{route('deal.edit',['deal'=>$deal, 'id'=>$deal->id])}} ">
                    <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                                viewBox="0 0 50 50" style="enable-background:new 0 0 50 50;" xml:space="preserve">
                        <title>Переименовать</title>
                       <g id="Layer_1_1_">
                               <path d="M18.293,31.707h6.414l24-24l-6.414-6.414l-24,24V31.707z M45.879,7.707l-3.586,3.586l-3.586-3.586l3.586-3.586
                                       L45.879,7.707z M20.293,26.121l17-17l3.586,3.586l-17,17h-3.586V26.121z"/>
                               <polygon points="43.293,19.707 41.293,19.707 41.293,46.707 3.293,46.707 3.293,8.707 31.293,8.707 31.293,6.707 1.293,6.707 
                                       1.293,48.707 43.293,48.707 	"/>
                       </g>
                    </svg>

                </a>
            </div>
            
            <form method="post"  class ="cursor-pointer border-2 border-green-500 border-solid  p-1 rounded-lg bg-red-300  h-8 w-8">
                
                @method('DELETE')
                @csrf
                <button formaction="{{route('dealDestroy',['id'=>$deal->id,'category'=>$category])}}" >

                    <svg id="Layer_1" data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                        <title>Удалить</title>
                        <path d="M2.88,5,5.11,24H18.89L21.12,5ZM17.11,22H6.89L5.12,7H18.88Z"/>
                        <polygon points="21 2 15 2 15 1 13 1 13 0 11 0 11 1 9 1 9 2 3 2 3 4 21 4 21 2"/>
                        <polygon points="10.23 17.66 12 15.89 13.77 17.66 15.18 16.24 13.41 14.47 15.18 12.71 13.77 11.29 12 13.06 10.23 11.29 8.82 12.71 10.59 14.47 8.82 16.24 10.23 17.66"/>
                    </svg>
                </button>
            </form>
        </div>
    </div>
    
</div>