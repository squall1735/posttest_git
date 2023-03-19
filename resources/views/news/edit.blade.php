<style>
    .alert {
        position: relative;
        padding: 0.75rem 1.25rem;
        margin-bottom: 1rem;
        border: 1px solid transparent;
        border-radius: 0.25rem;
    }
    .alert-danger {
        color: #761b18;
        background-color: #f9d6d5;
        border-color: #f7c6c5;
    }
    .container {
        min-width: 992px !important;
    }
    .row {
        display: flex;
        flex-wrap: wrap;
        margin-right: -15px;
        margin-left: -15px;
    }
    .col-md-1 {
      flex: 0 0 8.3333333333%;
      max-width: 8.3333333333%;
    }
    .col-md-2 {
      flex: 0 0 16.6666666667%;
      max-width: 16.6666666667%;
    }
    .col-md-3 {
      flex: 0 0 25%;
      max-width: 25%;
    }
    .col-md-4 {
      flex: 0 0 33.3333333333%;
      max-width: 33.3333333333%;
    }
    .col-md-5 {
      flex: 0 0 41.6666666667%;
      max-width: 41.6666666667%;
    }
    .col-md-6 {
      flex: 0 0 50%;
      max-width: 50%;
    }
    .col-md-7 {
      flex: 0 0 58.3333333333%;
      max-width: 58.3333333333%;
    }
    .col-md-8 {
      flex: 0 0 66.6666666667%;
      max-width: 66.6666666667%;
    }
    .col-md-9 {
      flex: 0 0 75%;
      max-width: 75%;
    }
    .col-md-10 {
      flex: 0 0 83.3333333333%;
      max-width: 83.3333333333%;
    }
    .col-md-11 {
      flex: 0 0 91.6666666667%;
      max-width: 91.6666666667%;
    }
    .col-md-12 {
      flex: 0 0 100%;
      max-width: 100%;
    }
    .image-wrapper {
        width: 100px;
        height: 100px;
        overflow: hidden;
        position: relative;
        background: rgba(0, 0, 0, 0.5);
        margin: 10px 0;
    }
    .image-wrapper img {
        width: 100%;
        position: absolute;
        left: 0;
        top: 50%;
        transform: translateY(-50%);
    }
</style>

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}"> {{-- en --}}

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>ฟอร์มแก้ไข</title>
    </head>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <body>
        <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
        <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
        <script src="//cdn.ckeditor.com/4.20.2/standard/ckeditor.js"></script>
        {{-- <link rel="stylesheet" href="{{ asset('toastify/toastify.css') }}">
        <script src="{{ asset('toastify/toastify.js') }}"></script> --}}
        @stack('js')
        {!! js_notify() !!}







        <div class="container">







            <form method="POST" action="{{ url('news/' . $rs->id) }}" enctype="multipart/form-data">
                {{ method_field('PATCH') }}
                @csrf

                <div class="row">
                    <div class="col-md-2" style="">
                        <label style="padding-left: 20%">หัวข้อ</label>
                    </div>
                    <div class="col-md-10">
                        <input type="text" name="header" value="{{ @$rs->header }}"/>
                    </div>
                </div>

                <br>

                <div class="row">
                    <div class="col-md-2" style="">
                        <label style="padding-left: 20%">วันที่เริ่มต้น</label>
                    </div>
                    <div class="col-md-4">
                        <input type="datetime-local" name="start_date" value="{{ @$rs->start_date }}"/>
                    </div>
                    <div class="col-md-2" style="">
                        <label>วันที่สิ้นสุด</label>
                    </div>
                    <div class="col-md-4">
                        <input type="datetime-local" name="end_date" value="{{ @$rs->end_date }}"/>
                    </div>
                </div>

                <br>

                <div class="row">
                    <div class="col-md-2" style="">
                        <label style="padding-left: 20%">ภาพตัวอย่าง</label>
                    </div>
                    <div class="col-md-10">
                        <input
                            type="file"
                            name="preview_picture"
                            id="inputImage"
                            class="form-control @error('preview_picture') is-invalid @enderror">
                        <div class="image-wrapper">
                            <img src="/images/{{ @$rs->preview_picture }}" alt="img_preview">
                        </div>
                        {{-- ชื่อไฟล์: --}}
                        <input type="hidden" name="preview_picture_tmp" value="{{ @$rs->preview_picture }}"/>
                    </div>
                </div>

                <br>

                <div class="row">
                    <div class="col-md-2" style="">
                        <label style="padding-left: 20%">ประเภทข่าว</label>
                    </div>
                    <div class="col-md-10">
                        <?php $categories = App\Models\Categories::pluck('name', 'id'); ?>
                        <select name="category_id">
                            <option value="">+ ประเภทข่าว +</option>
                            @foreach (@$categories as $key => $value)
                              <option value="{{ $key }}" {{ ( $key == @$rs->category_id) ? 'selected' : '' }}>
                                  {{ $value }}
                              </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <br>

                <div class="row">
                    <div class="col-md-2" style="">
                        <label style="padding-left: 20%">เนื้อหา</label>
                    </div>
                    <div class="col-md-10">
                        <textarea class="ckeditor form-control" name="detail">{{ @$rs->detail }}</textarea>
                    </div>
                </div>

                <br>

                <div class="row">
                    <div class="col-md-2" style="">
                        <label style="padding-left: 20%">แบบร่าง</label>
                    </div>
                    <div class="col-md-10">
                        <input type="checkbox" id="is_draft" name="is_draft" value="1" <?php echo (@$rs->is_draft == 1 ? 'checked' : '') ?> >
                    </div>
                </div>

                <br>

                <div class="row">
                    <div class="col-md-2" style="">
                        <label style="padding-left: 20%">สถานะใช้งาน</label>
                    </div>
                    <div class="col-md-10">
                        <input type="checkbox" id="is_enabled" name="is_enabled" value="1" <?php echo (@$rs->is_enabled == 1 ? 'checked' : '') ?>>
                    </div>
                </div>

                <br><br>

                <div class="row">
                    <div class="col-md-12" style="padding-left: 10%">
                        <button type="submit">แก้ไขข้อมูล</button>
                        &emsp;&emsp;&emsp;
                        <button type="button" onclick="window.location='/news';">ย้อนหลับ</button>
                    </div>
                </div>
            </form>
        </div>
    </body>

</html>

@push('js')
    <script type="text/javascript" src="{{ asset('vendor/jsvalidation/js/jsvalidation.js') }}"></script>
    {!! JsValidator::formRequest('App\Http\Requests\NewsRequest') !!}
@endpush
