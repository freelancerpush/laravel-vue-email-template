@extends('layouts.app')
@section('content')
<div class="content">
  <nav class="navbar navbar-default">
    <div class="container-fluid">
      <ul class="nav navbar-nav">
        <router-link :to="'/'"><li >Home</li></router-link>
        <router-link :to="'show-count'"><li>Show Counts</li></router-link>
      </ul>
    </div>
  </nav>
  <router-view></router-view>
</div>
@endsection

@section('scripts')
<script type="text/x-template" id="modal-template">
  <transition name="modal">
    <div class="modal-mask">
      <div class="modal-wrapper">
        <div class="modal-container">
          <div class="modal-header">
            <slot name="header">
              default header
            </slot>
          </div>
          <div class="modal-body">
            <slot name="body">
            </slot>
          </div>
          <div class="modal-footer">
            <slot name="footer">
            </slot>
          </div>
        </div>
      </div>
    </div>
  </transition>
</script>
@endsection
