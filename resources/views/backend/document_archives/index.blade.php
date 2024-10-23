@extends('layouts.admin')


@section('content')


    <div class="card shadow mb-4">
        {{-- breadcrumb part  --}}
        <div class="card-header py-3 d-flex justify-content-between">
            <div class="card-naving">
                <h3 class="font-weight-bold text-primary">
                    <i class="fa fa-folder"></i>
                    {{ __('panel.manage_document_archive') }}
                </h3>
                <ul class="breadcrumb">
                    <li>
                        <a href="{{ route('admin.index') }}">{{ __('panel.main') }}</a>
                        @if (config('locales.languages')[app()->getLocale()]['rtl_support'] == 'rtl')
                            <i class="fa fa-solid fa-chevron-left chevron"></i>
                        @else
                            <i class="fa fa-solid fa-chevron-right chevron"></i>
                        @endif
                    </li>
                    <li>
                        {{ __('panel.show_document_archives') }}
                    </li>
                </ul>
            </div>

            <div class="ml-auto">
                @ability('admin', 'create_document_archives')
                    <a href="{{ route('admin.document_archives.create') }}" class="btn btn-primary">
                        <span class="icon text-white-50">
                            <i class="fa fa-plus-square"></i>
                        </span>
                        {{ __('panel.add_new_document_archive') }}
                    </a>
                @endability
            </div>

        </div>

        <div class="card-body">

            @include('backend.document_archives.filter.filter')


            <div class="table-responsive">
                <table class="table table-hover table-striped table-bordered dt-responsive nowrap"
                    style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                    <thead>
                        <tr>
                            <th class="wd-5p border-bottom-0">#</th>
                            <th class="wd-15p border-bottom-0">{{ __('panel.document_archive_name') }}</th>
                            <th class="wd-15p border-bottom-0">{{ __('panel.published_on') }}</th>
                            <th class="wd-15p border-bottom-0">{{ __('panel.published_by') }}</th>
                            <th class="wd-15p border-bottom-0">{{ __('panel.status') }}</th>
                            <th class="wd-15p border-bottom-0">{{ __('panel.actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>


                        @forelse ($documentArchives as $docArchive)
                            <tr>
                                <td class="text-center"><input type="checkbox" name="checkfilter"
                                        value="{{ $docArchive->id }}"></td>
                                <td>{{ $docArchive->doc_archive_name }}</td>
                                <td>{{ $docArchive->created_at->format('Y-m-d ') }}</td>
                                <td>{{ $docArchive->created_by }}</td>
                                <td>{{ $docArchive->status() }}</td>
                                <td>
                                    <div class="btn-group btn-group-sm">
                                        <a href="{{ route('admin.document_archives.edit', $docArchive->id) }}"
                                            class="btn btn-primary">
                                            <i class="fa fa-edit"></i>
                                        </a>
                                        <a href="javascript:void(0);"
                                            onclick=" if( confirm('{{ __('panel.confirm_delete_message') }}') ){document.getElementById('delete-document-Archives-{{ $docArchive->id }}').submit();}else{return false;}"
                                            class="btn btn-danger">
                                            <i class="fa fa-trash "></i>
                                        </a>
                                    </div>
                                    <form action="{{ route('admin.document_archives.destroy', $docArchive->id) }}"
                                        method="post" class="d-none" id="delete-document-Archives-{{ $docArchive->id }}">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center">{{ __('panel.no_found_item') }}</td>
                            </tr>
                        @endforelse

                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="6">
                                <div class="float-right">
                                    {!! $documentArchives->appends(request()->all())->links() !!}
                                </div>
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>


    </div>
@endsection
