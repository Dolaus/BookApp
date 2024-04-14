@extends('admin.layouts.main')
@section('content')
    <div class="container">
        <table class="table">
            <thead>
            <tr>
                <th scope="col">Start of booking</th>
                <th scope="col">End of booking</th>
                <th class="text-center" scope="col">Comment</th>
                <th class=" text-center" scope="col">Approving</th>
            </tr>
            </thead>


            <tbody>
            @foreach($bookings as $book)
                <tr>
                    <td>{{$book->start}}</td>
                    <td>{{$book->end}}</td>

                    <td class="text-center"><a href="#"><i class="fa-solid fa-eye"></i></a></td>
                    <td class="text-center">
                        <div class="form-check">
                            <input class="form-check-input approveClass" data-id="{{$book['id']}}"
                                   {{$book['is_approve'] == 1 ? "checked": ""}} type="checkbox" value="">
                        </div>
                    </td>
                </tr>

            @endforeach

            </tbody>
        </table>
    </div>
@endsection

@push('js')
    <script>
        $('.approveClass').click(function () {
            let bookId = $(this).data('id');
            let isChecked = $(this).prop('checked');
            let csrfToken = $('meta[name="csrf-token"]').attr('content');

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                },
                url: '/approving',
                method: 'PUT',
                data: {
                    bookId: bookId,
                    is_approved: isChecked
                },
                success: function (response) {
                    console.log('Request successful');
                    console.log(response);
                },
                error: function (xhr, status, error) {
                    console.error('Error occurred:', error);
                }
            });
        });
    </script>
@endpush
