<div >
    <!-- He who is contented is rich. - Laozi -->
    <div class="m-2 p-2 border-solid border-yellow-500 border-4 rounded-2xl box-border bg-yellow-100">{!!$msg!!}
    
        @if($dealsList and sizeof($dealsList)>0)
            <div class="m-2 p-2 border-solid border-green-500 border-4 rounded-2xl box-border bg-green-200">
                @foreach($dealsList as $deal)
                <div>
                    @if($allCategories)
                        {{$getCategoryName($deal->category_id)}}
                    @endif

                    
                    <x-deal-comp :deal="$deal" ></x-deal-comp>
                    
                </div>


                @endforeach
            </div>
        @endif
    
    </div>
</div>