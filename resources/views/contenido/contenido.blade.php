@extends('principal')
@section('contenido')
        <template v-if="menu==0">
                <user-component></user-component>
        </template>

        <template v-if="menu==1">
                <rol-component></rol-component>
        </template>
@endsection