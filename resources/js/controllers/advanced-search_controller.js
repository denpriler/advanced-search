import moment from 'moment'

export default class extends window.Controller {
    static targets = ['all_words', 'any_words', 'none_words', 'date_from', 'date_to']

    connect() {
        for (const table of $('.advanced-search-table')) {
            const path = $(table).attr('route')
            const model = $(table).attr('model')
            const view = $(table).attr('view')
            const urlParams = new URLSearchParams(path)
            urlParams.set('model', model)

            const datatable = $(table).DataTable({
                processing: true,
                serverSide: true,
                searching: false,
                ajax: {
                    url: `${path}?${urlParams.toString()}`,
                    type: 'GET',
                    dataFilter: function (data) {
                        let json = $.parseJSON(data);
                        json.recordsTotal = json.total;
                        json.recordsFiltered = json.total;

                        return JSON.stringify(json); // return JSON string
                    }
                },
                columns: JSON.parse($(table).attr('columns')),
                ordering: false,
                createdRow: function (row, data, dataIndex) {
                    const title = $(row).children()[0];
                    $(title).html(
                        "<a data-turbo=\"false\" data-turbo='false' class='btn-link'"
                        + "href='" + `${view}/`
                        + datatable.row(dataIndex).data().id
                        + "'>"
                        + $(title).text() + " </a>"
                    );

                    const date = $(row).children()[$(row).children().length - 1];
                    try {
                        $(date).html(moment($(date).text()).format('DD/MM/YYYY hh:mm:ss'))
                    } catch (e) {
                        $(date).html($(date).text())
                    }
                }
            })
        }
    }

    clear() {
        this.all_wordsTarget.value = ''
        this.any_wordsTarget.value = ''
        this.none_wordsTarget.value = ''
        this.date_fromTarget.value = ''
        this.date_toTarget.value = ''

        this.refreshTables()
    }

    search() {
        const allWords = this.all_wordsTarget.value.toString() ?? null
        const anyWords = this.any_wordsTarget.value.toString() ?? null
        const noneWords = this.none_wordsTarget.value.toString() ?? null
        const dateFrom = this.date_fromTarget.valueAsNumber ?? null
        const dateTo = this.date_toTarget.valueAsNumber ?? null

        this.refreshTables(allWords, anyWords, noneWords, dateFrom, dateTo)
    }

    refreshTables(allWords = null, anyWords = null, noneWords = null, dateFrom = null, dateTo = null) {
        for (const table of $('.advanced-search-table')) {
            const path = $(table).attr('route')
            const datatable = $(table).DataTable()
            const model = $(table).attr('model')
            const urlParams = new URLSearchParams()
            urlParams.set('model', model)
            if (allWords) {
                urlParams.set('all_words', allWords)
            }
            if (anyWords) {
                urlParams.set('any_words', anyWords)
            }
            if (noneWords) {
                urlParams.set('none_words', noneWords)
            }
            if (dateFrom) {
                urlParams.set('date_from', dateFrom / 1000)
            }
            if (dateTo) {
                urlParams.set('date_to', dateTo / 1000)
            }
            datatable.ajax.url(path + '?' + urlParams.toString())
            datatable.ajax.reload()
        }
    }
}
