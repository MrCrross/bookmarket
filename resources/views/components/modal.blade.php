<div class="hystmodal" {{$attributes}} aria-hidden="true">
    <div class="hystmodal__wrap">
        <div class="hystmodal__window rounded-xl" role="dialog" aria-modal="true">
            <div class="rounded-xl">
                <div class="w-full rounded-t-xl p-4 border-b-4 border-gray-800 bg-gray-400 text-gray-50">
                    <span class="modal_header">{{$header}}</span>
                    <a class="cursor-pointer float-right border border-transparent px-2 rounded-full hover:border-white" data-hystclose>&times;</a>
                </div>
                <div class="modal_body flex flex-col p-5 sm:justify-center items-center">
                   {{$slot}}
                </div>
            </div>
        </div>
    </div>
</div>
