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
        width: 300px;
        height: 300px;
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
        <title>Laravel Cache Post-test</title>
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



            <h1>====================     Backend (ส่วนบันทึกข้อมูล)      ====================</h1>



            <form method="POST" action="/news" enctype="multipart/form-data">
                @csrf

                <div class="row">
                    <div class="col-md-2" style="">
                        <label style="padding-left: 20%">หัวข้อ</label>
                    </div>
                    <div class="col-md-10">
                        <input type="text" name="header"/>
                    </div>
                </div>

                <br>

                <div class="row">
                    <div class="col-md-2" style="">
                        <label style="padding-left: 20%">วันที่เริ่มต้น</label>
                    </div>
                    <div class="col-md-4">
                        <input type="datetime-local" name="start_date" />
                    </div>
                    <div class="col-md-2" style="">
                        <label>วันที่สิ้นสุด</label>
                    </div>
                    <div class="col-md-4">
                        <input type="datetime-local" name="end_date" />
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
                              <option value="{{ $key }}" {{ ( $key == @$_GET['category_id']) ? 'selected' : '' }}>
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
                        <textarea class="ckeditor form-control" name="detail"></textarea>
                    </div>
                </div>

                <br>

                <div class="row">
                    <div class="col-md-2" style="">
                        <label style="padding-left: 20%">แบบร่าง</label>
                    </div>
                    <div class="col-md-10">
                        <input type="checkbox" id="is_draft" name="is_draft" value="1">
                    </div>
                </div>

                <br>

                <div class="row">
                    <div class="col-md-2" style="">
                        <label style="padding-left: 20%">สถานะใช้งาน</label>
                    </div>
                    <div class="col-md-10">
                        <input type="checkbox" id="is_enabled" name="is_enabled" value="1">
                    </div>
                </div>

                <br><br>

                <div class="row">
                    <div class="col-md-12" style="padding-left: 10%">
                        <button type="submit">เพิ่มข้อมูล</button>
                    </div>
                </div>
            </form>




            <br><br><br><br><br><br>
            <h1>====================     Backend (การจัดการข้อมูล)      ====================</h1>
            <br>




            <form method="GET" action="/news">
                <b>ค้นหา หัวข้อ / รายละเอียด</b><input type="text" name="keyword" value="{{ @$_GET['keyword'] }}"/>
                <br>
                <b>ค้นหา หมวดหมู่</b>
                <select name="keyword_2">
                    <option value="">+ ประเภทข่าว +</option>
                    @foreach (@$categories as $key => $value)
                      <option value="{{ $key }}" {{ ( $key == @$_GET['keyword_2']) ? 'selected' : '' }}>
                          {{ $value }}
                      </option>
                    @endforeach
                </select>
                <br>
                <b>ค้นหา วันที่เริ่มต้น</b><input type="datetime-local" name="keyword_3" value="{{ @$_GET['keyword_3'] }}"/>
                <br>
                <b>ค้นหา วันที่สิ้นสุด</b><input type="datetime-local" name="keyword_4" value="{{ @$_GET['keyword_4'] }}"/>
                <br>
                <b>ค้นหา แบบร่าง</b><input type="checkbox" id="keyword_5" name="keyword_5" value="1" <?php echo (@$_GET['keyword_5'] == 1 ? 'checked' : '') ?>>
                <br>
                <b>ค้นหา สถานะใช้งาน</b><input type="checkbox" id="keyword_6" name="keyword_6" value="1" <?php echo (@$_GET['keyword_6'] == 1 ? 'checked' : '') ?>>
                <br>
                <button type="submit">ค้นหา</button>
            </form>
            <table border=1>
                <tr>
                    <th>id</th>
                    <th>ประเภทข่าว</th>
                    <th>หัวข้อ</th>
                    <th>ภาพตัวอย่าง</th>
                    <th>วันที่เริ่มต้น</th>
                    <th>วันที่สิ้นสุด</th>
                    <th>รายละเอียด</th>
                    <th>แบบร่าง</th>
                    <th>สถานะใช้งาน</th>
                    <th>จัดการ</th>
                </tr>
                @if(@$rs_backend)
                    @foreach ($rs_backend as $key => $val)
                        <tr>
                            <td>{{ @$val->id }}</td>
                            <td>{{ @$val->category_id ? $val->categories->name : '-' }}</td>
                            <td>{{ @$val->header ?: '-' }}</td>
                            <td>{{ @$val->preview_picture ?: '-' }}</td>
                            <td>{{ @$val->start_date ?: '-' }}</td>
                            <td>{{ @$val->end_date ?: '-' }}</td>
                            <td>{{ @$val->detail ?: '-' }}</td>
                            <td>{{ @$val->is_draft ?: '0' }}</td>
                            <td>{{ @$val->is_enabled ?: '0' }}</td>
                            <td>
                                <a href="{{ url('news/' . @$val->id . '/edit') }}" title="แก้ไข">
                                    <button id="btnFA" class="btn btn-sm btn-secondary">แก้ไข</button>
                                </a>
                                <form method="POST" action="{{ url('news/' . @$val->id) }}"
                                    accept-charset="UTF-8" style="display:inline">
                                    {{ method_field('DELETE') }}
                                    {{ csrf_field() }}
                                    <button type="submit" class="btn btn-sm btn-danger" title="ลบ"
                                        onclick="return confirm(&quot;Confirm delete?&quot;)">
                                        ลบ
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                @endif
            </table>



            <br><br><br><br><br><br><br><br><br><br>
            <h1>====================     Frontend (การแสดงผลเบื้องต้น)      ====================</h1>
            <br>



            @if(@$rs_frontend)
                @foreach ($rs_frontend as $key => $val)
                    <?php
                        $type_news_1 = $type_news_2 = $type_news_3 = $type_news_4 = false;
                    ?>
                    @if (@$val->is_enabled == 1)
                        @if (@$val->category_id == 1)
                            @if(!$type_news_1)
                                <h2>++ หมวดหมู่-ข่าวกีฬา ++</h2>
                                <?php $type_news_1 = true; ?>
                            @endif
                            <table border=1>
                                <tr>
                                    <td class="image-wrapper">
                                        <a target="_blank" href="/images/{{ @$val->preview_picture }}">
                                            <img src="/images/{{ @$val->preview_picture }}" alt="img_preview">
                                        </a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        {{ @$val->header ?: '-' }}
                                        <a target="_blank" href="{{ url('news/' . $val->id) }}">
                                            อ่านต่อที่นี่
                                        </a>
                                    </td>
                                </tr>
                            </table>
                        @endif
                        @if (@$val->category_id == 2)
                            @if(!$type_news_1)
                                <h2>++ หมวดหมู่-ข่าวต่างประเทศ ++</h2>
                                <?php $type_news_2 = true; ?>
                            @endif
                            <table border=1>
                                <tr>
                                    <td class="image-wrapper">
                                        <a target="_blank" href="/images/{{ @$val->preview_picture }}">
                                            <img src="/images/{{ @$val->preview_picture }}" alt="img_preview">
                                        </a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        {{ @$val->header ?: '-' }}
                                        <a target="_blank" href="{{ url('news/' . $val->id) }}">
                                            อ่านต่อที่นี่
                                        </a>
                                    </td>
                                </tr>
                            </table>
                        @endif
                        @if (@$val->category_id == 3)
                            @if(!$type_news_1)
                                <h2>++ หมวดหมู่-ข่าวการเมือง ++</h2>
                                <?php $type_news_3 = true; ?>
                            @endif
                            <table border=1>
                                <td class="image-wrapper">
                                    <a target="_blank" href="/images/{{ @$val->preview_picture }}">
                                        <img src="/images/{{ @$val->preview_picture }}" alt="img_preview">
                                    </a>
                                </td>
                                <tr>
                                    <td>
                                        {{ @$val->header ?: '-' }}
                                        <a target="_blank" href="{{ url('news/' . $val->id) }}">
                                            อ่านต่อที่นี่
                                        </a>
                                    </td>
                                </tr>
                            </table>
                        @endif
                        @if (@$val->category_id == 4)
                            @if(!$type_news_1)
                                <h2>++ หมวดหมู่-ข่าวสังคม ++</h2>
                                <?php $type_news_4 = true; ?>
                            @endif
                            <table border=1>
                                <td class="image-wrapper">
                                    <a target="_blank" href="/images/{{ @$val->preview_picture }}">
                                        <img src="/images/{{ @$val->preview_picture }}" alt="img_preview">
                                    </a>
                                </td>
                                <tr>
                                    <td>
                                        {{ @$val->header ?: '-' }}
                                        <a target="_blank" href="{{ url('news/' . $val->id) }}">
                                            อ่านต่อที่นี่
                                        </a>
                                    </td>
                                </tr>
                            </table>
                        @endif
                    @endif
                @endforeach
            @endif



        </div>
    </body>

</html>

@push('js')
    <script type="text/javascript" src="{{ asset('vendor/jsvalidation/js/jsvalidation.js') }}"></script>
    {!! JsValidator::formRequest('App\Http\Requests\NewsRequest') !!}
@endpush
