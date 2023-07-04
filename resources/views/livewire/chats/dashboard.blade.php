@include('partials.menu')
  <!-- BEGIN: Content-->
  <div class="app-content content chat-application">
    <!-- BEGIN: Header-->
    <div class="content-overlay"></div>
    <div class="header-navbar-shadow"></div>

        <div class="content-area-wrapper container-xxl p-0">
      <div class="sidebar-left">
        <div class="sidebar">

        @include('livewire.chats.app-chat-sidebar')

        </div>
      </div>
      <div class="content-right">
        <div class="content-wrapper">
          <div class="content-body">
            
            <div class="body-content-overlay"></div>
<!-- Main chat area -->
<section class="chat-app-window">
  <!-- To load Conversation -->
  @if ($unreadMessages > 0)
  <div class="start-chat-area">
    <div class="mb-1 start-chat-icon">
      <i data-feather="message-square"></i>
    </div>
    <h4 class="sidebar-toggle start-chat-text">{{ $unreadMessages }} New Conversation</h4>
  </div>
@else
<div class="start-chat-area">
    <div class="mb-1 start-chat-icon">
      <i data-feather='bell-off'></i>
    </div>
    <h4 class="sidebar-toggle start-chat-text">No New Conversation</h4>
  </div>
@endif
  <!--/ To load Conversation -->

  <!-- Active Chat -->

          </div>
        </div>
      </div>
    </div>
    
  </div>
  <!-- End: Content-->





  
  <div class="sidenav-overlay"></div>
  <div class="drag-target"></div>

  
  <!-- BEGIN: Footer-->
<footer class="footer  footer-light">
  <p class="clearfix mb-0">

  </p>
</footer>
<button class="btn btn-primary btn-icon scroll-top" type="button"><i data-feather="arrow-up"></i></button>
<!-- END: Footer-->

