@extends('app-theme.master')

@section('title')
    Sửa mẫu tin nhắn
@endsection

@section('content')
    <div class="intro-y col-span-12 lg:col-span-6">
        <form action="" id="form">
            <div class="intro-y box p-5">
                    <h2 class="font-medium text-base mr-auto">Nội dung mẫu tin nhắn</h2>
                <br>
                <div>
                    <label for="crud-form-1" class="form-label">Tiêu đề</label>
                    <input id="crud-form-1" type="text" class="form-control form-control-rounded w-full" placeholder="Tiêu đề của mail">
                </div>
                <div class="mt-3">
                    <label for="crud-form-1" class="form-label">Tên người gửi</label>
                    <input id="crud-form-1" type="text" class="form-control form-control-rounded w-full" placeholder="Tên của người sẽ gửi mail cho bạn">
                </div>
                <div class="mt-3">
                    <label>Nội dung của mail</label>
                    <div class="mt-2">
                        <div class="editor" value="a" id="editor">
                            <p>Xin chào.....</p>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <div class="intro-y col-span-12 lg:col-span-6">
        <div class="intro-y box">
            <div class="flex flex-col sm:flex-row items-center p-5 border-b border-slate-200/60 dark:border-darkmode-400">
                <h2 class="font-medium text-base mr-auto">Ảnh bìa</h2>
            </div>
            <form data-single="true" action="/file-upload" class="dropzone">
                <div class="fallback">
                    <input name="file" type="file" />
                </div>
                <div class="dz-message" data-dz-message>
                    <div class="text-lg font-medium">Drop files here or click to upload.</div>
                    <div class="text-slate-500">
                        This is just a demo dropzone. Selected files are <span class="font-medium">not</span> actually uploaded.
                    </div>
                </div>
            </form>
        </div>

        <div class="intro-y box mt-5">
            <div class="flex flex-col sm:flex-row items-center p-5 border-b border-slate-200/60 dark:border-darkmode-400">
                <h2 class="font-medium text-base mr-auto">Thời gian</h2>
                <div class="form-check form-switch w-full sm:w-auto sm:ml-auto mt-3 sm:mt-0">
                    <label class="form-check-label ml-0" for="show-example-1">Lặp lại</label>
                    <input id="toggle-repeat" class="show-code form-check-input mr-0 ml-3" type="checkbox">
                </div>
            </div>
            <div id="basic-select" class="p-5">
                <div class="preview">
                    <div id="repeat" class="mt-5">
                        <div class="mt-5">
                            <label>Sẽ tự động gửi vào</label>
                            <div class="mt-2">
                                <input type="text" class="datepicker w-56 mx-auto" data-single-mode="true">
                                <input type="time" class="time w-56 mx-auto" value="00:00">
                            </div>
                        </div>

                        <div class="text-right mt-5">
                            <button type="button" class="btn btn-outline-secondary w-24 mr-1">Hủy</button>
                            <button id="button_submit" type="button" class="btn btn-primary w-24">Lưu</button>
                        </div>
                    </div>
{{--                    ===============--}}
                    <div id="no-repeat" class="mt-5" style="display: none">
                        <div class="mt-5">
                            <label>Lặp lại sau mỗi</label>
                            <div class="mt-2">
                                <select data-placeholder="Select your favorite actors" class="tom-select w-full">
                                    <option value="1">2 giờ</option>
                                    <option value="2">4 giờ</option>
                                    <option value="3">6 giờ</option>
                                    <option value="4">8 giờ</option>
                                    <option value="5">12 giờ</option>
                                    <option value="7">1 ngày</option>
                                    <option value="8">2 ngày</option>
                                    <option value="0">3 ngày</option>
                                    <option value="45">4 ngày</option>
                                </select>
                            </div>
                        </div>

                        <div class="text-right mt-5">
                            <button type="button" class="btn btn-outline-secondary w-24 mr-1">Hủy</button>
                            <button id="button_submit" type="button" class="btn btn-primary w-24">Lưu</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>



@endsection

@section('script')
    <script src="{{asset('app/js/ckeditor-classic.js')}}"></script>
    <script src="{{asset('app/js/jquery-3.6.0.js')}}"></script>
    <script>
        $("#toggle-repeat").on('change', function() {
            if($("#toggle-repeat").is(':checked')) {
                $("#repeat").css('display', 'none')
                $("#no-repeat").css('display', 'block')
            } else {
                $("#repeat").css('display', 'block')
                $("#no-repeat").css('display', 'none')
            }
        })
    </script>
@endsection
