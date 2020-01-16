<div class="card shadow mb-4">
    <div class="card-header py-3 @if(isset($actions)) d-sm-flex align-items-center justify-content-between @endif">
        <h6 class="m-0 font-weight-bold text-primary">{{ $title }}</h6>
        {{ $actions ?? '' }}
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <div class="row">
                <div class="col-sm-12">
                    {{ $slot }}
                </div>
            </div>
        </div>
    </div>
</div>
