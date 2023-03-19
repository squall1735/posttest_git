<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}"> {{-- en --}}

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>Bangkok Post - {{ $rs->categories->name }}</title>
    </head>

    <div class="row">
        <label style="font-size:50px;">{{ $rs->header }}</label> &emsp; <br><label>ข่าวเมื่อวันที่ {{ $rs->start_date }}</label>
    </div>
    <div class="row">
        <?php echo $rs->detail; ?>
    </div>
</html>
