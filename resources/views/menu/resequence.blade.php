@extends('layouts.master')

@section('content')

<div class="container-fluid">
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-body">
          <div class="dd">
            <ul class="dd-list">
              <li class="dd-item" data-id="1">
                <div class="dd-handle">Item 1</div>
              </li>
              <li class="dd-item" data-id="2">
                <div class="dd-handle">Item 2</div>
              </li>
              <li class="dd-item" data-id="3">
                <div class="dd-handle">Item 3</div>
                <ul class="dd-list">
                  <li class="dd-item" data-id="4">
                    <div class="dd-handle">Item 4</div>
                  </li>
                  <li class="dd-item" data-id="5" data-foo="bar">
                    <div class="dd-nodrag">Item 5</div>
                  </li>
                </ul>
              </li>
            </ul>
          </div>
        </div>
        <div class="card-footer">
          <button type="submit" id="btnSimpan" class="btn btn-primary">
            <i class="fa fa-save"></i> Simpan
          </button>
          <button type="submit" id="btnSimpan" class="btn btn-secondary">
            <i class="fa fa-save"></i> Reset
          </button>
          <a href="{{ route('menu.index') }}" class="btn btn-danger">
            <i class="fa fa-window-close"></i>
            BATAL
          </a>
        </div>
      </div>
    </div>
  </div>
</div>


@endsection