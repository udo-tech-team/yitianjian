<div class="login-box">
    <div class="row">
     <button type="button" class="btn btn-success">Register Success</button>
    </div>
    <br/>
    <div class="row">
    <a href="<?php 
        echo $this->Html->url(array(
        "controller"=>"users",
        "action"=>"ucenter"));
        ?>" 
        class="btn btn-info" role="button">Link Button</a>
    </div>
</div>
