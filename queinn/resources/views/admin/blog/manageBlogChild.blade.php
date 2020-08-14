@php
{{--    $cat = [];--}}
{{--    if($selectCategory!=''){--}}
{{--        $cat = explode(',', $selectCategory);--}}
{{--    }--}}


@endphp
{{--@foreach($childs as $child)--}}

{{--	<input type="checkbox" name="categories[]" class="flat-red" value="{{ $child->id }}" {{ in_array($child->id,$cat) ? 'checked="checked"' : '' }} >{{ "&nbsp; --- &nbsp;".$child->name }} <br/>--}}
{{--	@if(count($child->childs))--}}
{{--            @include('admin/blog/manageBlogChild',['childs' => $child->childs])--}}
{{--        @endif--}}
{{--	</option>--}}
{{--@endforeach--}}

@if($childs)
    @foreach($childs as $child)

        <input type="checkbox" name="tags[]" class="flat-red" value="{{ $child->id }}" {{ in_array($child->id,$cat) ? 'checked="checked"' : '' }} >{{ "&nbsp; --- &nbsp;".$child->name }} <br/>
        @if(count($child->childs))
        @include('admin/blog/manageBlogChild',['childs' => $child->childs])
        @endif
        </option>
    @endforeach
@endif

