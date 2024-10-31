<?php
if (isset($id)) { ?>
<table id="<?php echo  $lookupName; ?>" class="lookup-grid"></table>
<?php
} else { ?>
<table id="<?php echo $lookupName; ?>" class="lookup-grid"></table>
<?php } ?>
<div class="loadingMessage">
    <img class="loading-image" src="{{ asset('libraries/tas-lib/img/loading-lookup.gif') }}" alt="Loading">
    <p class="loading-text">Loading data...</p>

</div>

<script src="{{ asset('libraries/tas-lookup/'. $filename.'.js?version='. config('app.version')) }}">  



