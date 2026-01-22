@if(\Laratrust::isAbleTo($actionBase.'.show'))
<a href="{{route($actionBase.'.show', $id)}}" class="btn btn-xs btn-primary" title="Voir"><i class="fa fa-eye"></i></a>
@endif
@if(\Laratrust::isAbleTo($actionBase.'.edit'))
<a href="{{route($actionBase.'.edit', $id)}}" class="btn btn-xs btn-warning" style="margin: 0 10px;" title="Modifier"><i class="fa fa-edit"></i></a>
@endif
@if(\Laratrust::isAbleTo($actionBase.'.destroy'))
<a href="{{route($actionBase.'.destroy', $id)}}" class="btn btn-xs btn-danger btn-delete" title="Supprimer"><i class="fa fa-trash"></i></a>
@endif
