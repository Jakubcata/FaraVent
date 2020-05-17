<table class="mb-0 table">
    <tbody>
    @foreach($topics as $topic)
    <tr>
        <th scope="row">{{ $topic }}</th>
            <td>
                <button
                class="mr-2 btn-icon btn-icon-only btn btn-outline-danger"
                href="#"
                onclick="return deleteTopic('{{$topic}}');"
                data-toggle="tooltip"
                data-placement="top"
                title="Unsubscribe"
                >
                <i class="pe-7s-trash btn-icon-wrapper"> </i>

        </td>
    </tr>
    @endforeach
    </tbody>
</table>
