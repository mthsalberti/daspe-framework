<script>
    try{
        listenToFormFieldsFuncionalities();
    }catch (e) {}
</script>

@if(view()->exists('app_layout.'.$slug.'.scripts.edit-add'))
    @include('app_layout.'.$slug.'.scripts.edit-add')
@endif
