@extends('layout.layout') <!-- Giả sử bạn đang sử dụng layout.blade.php làm bố cục chung -->

@section('content')
    <!-- ============================ Page Title Start ================================== -->
    <div class="page-title">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-md-12">
                    <h2 class="ipt-title">{{ $title }}</h2>
                    <span class="ipn-subtitle">{{ $title }}</span>
                </div>
            </div>
        </div>
    </div>
    <!-- ============================ Page Title End ================================== -->

    <!-- ============================ Listing Start ================================== -->
    <section class="gray-simple">
        <div class="container">
            <!-- Table for displaying the listings -->
            <h4 class="text-warning">- {{ __('post.title_noread') }}: {{ $count_unread }}</h4>
            <div class="row">
                <div class="col-lg-12 col-md-12">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>{{ __('common.title') }}</th>
                                <th>{{ __('common.name') }}</th>
                                <th>{{ __('common.phone_number') }}</th>
                                <th>Email</th>
                                <th>{{ __('common.address') }}</th>
                                <th>{{ __('common.post_date') }}</th>
                                <th>{{ __('common.action') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($baidangnhanhs as $baidang)
                                <tr class="{{ is_null($baidang->isRead) ? 'unread' : '' }}">
                                    <td class="{{ is_null($baidang->isRead) ? 'unread' : '' }}">

                                        <!-- Red dot for unread posts -->
                                        @if (is_null($baidang->isRead))
                                            <span class="red-dot"></span>
                                        @endif
                                        {{ $baidang->id }}
                                    </td>
                                    <td class="{{ is_null($baidang->isRead) ? 'unread' : '' }}">{{ $baidang->title }}</td>
                                    <td class="{{ is_null($baidang->isRead) ? 'unread' : '' }}">{{ $baidang->name }}</td>
                                    <td class="{{ is_null($baidang->isRead) ? 'unread' : '' }}">{{ $baidang->phone }}</td>
                                    <td class="{{ is_null($baidang->isRead) ? 'unread' : '' }}">{{ $baidang->email }}</td>
                                    <td class="{{ is_null($baidang->isRead) ? 'unread' : '' }}">{{ $baidang->address }}
                                    </td>
                                    <td class="{{ is_null($baidang->isRead) ? 'unread' : '' }}">
                                        {{ $baidang->created_at->format('d/m/Y H:i') }}</td>
                                    <td class="{{ is_null($baidang->isRead) ? 'unread' : '' }} text-center">
                                        <!-- Edit button -->
                                        <a href="{{ route('chiTietBaiDangNhanh', $baidang->slug) }}" target="_blank"
                                            class="btn btn-primary btn-sm mb-3"
                                            id="detail-btn-{{ $baidang->id }}">{{ __('common.detail') }}</a>
                                        <!-- Delete button -->
                                        <form action="{{ route('deleteBaiDangNhanh', $baidang->id) }}" method="POST"
                                            style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm"
                                                onclick="return confirm('{{ __('common.title_delete') }}')">{{ __('common.delete') }}</button>
                                        </form>


                                    </td>
                                </tr>
                            @endforeach
                        </tbody>

                    </table>

                    <!-- Pagination links -->
                    <div class="pagination-wrapper">
                        {{ $baidangnhanhs->links() }}
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- ============================ Listing End ================================== -->
@endsection
