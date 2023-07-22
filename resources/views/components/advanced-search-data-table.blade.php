{!! $dataTable->table() !!}

@push('scripts')
    {{--    {!! $dataTable->scripts() !!}--}}
    <script type="module">
        const urlParams = new URLSearchParams(window.location.search);

        $(function () {
            const table = $('#{{ class_basename($model) }}_table').DataTable({
                processing: true,
                serverSide: true,
                searching: false,
                ajax: {
                    url: "{{ route('platform.advanced-search.query', ['model' => $model]) }}?" + urlParams.toString(),
                    type: 'GET',
                    dataFilter: function (data) {
                        let json = jQuery.parseJSON(data);
                        json.recordsTotal = json.total;
                        json.recordsFiltered = json.total;

                        return JSON.stringify(json); // return JSON string
                    }
                },
                columns: {!! json_encode($dataTable->getColumns()->toArray()) !!},
                ordering: false,
                createdRow: function (row, data, dataIndex) {
                    const title = $(row).children()[0];
                    $(title).html(
                        "<a data-turbo=\"false\" data-turbo='false' class='btn btn-link' href='{{ route('platform.' . $model::slug() . '.item.view') }}/"
                        + table.row(dataIndex).data().id
                        + "'>"
                        + $(title).text() + " </a>"
                    );
                }
            });
            table.buttons().remove();
        });
    </script>
@endpush
