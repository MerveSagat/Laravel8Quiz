<x-app-layout>
    <x-slot name="header"> Quizzes </x-slot>
    <div class="card">
        <div class="card-body">
            <h5 class="card-title float-right">
                <a href="{{ route('quizzes.create') }}" class="btn btn-sm btn-primary">
                    <i class="fa fa-plus"></i> Create Quiz</a>
            </h5>
            <form method="GET" action="">
                <div class="form-row">
                    <div class="col-md-2">
                        <input type="text" name="title" value="{{ request()->get('title') }}" placeholder="Quiz Name"
                            class="form-control">
                    </div>
                    <div class="col-md-2">
                        <select class="form-control" onchange="this.form.submit()" name="status">
                            <!-- burada option dan seçer seçmez herhangi bir butona tıklamadan seçimi agılaması için onclick jabascript kodu yazdık. -->
                            <option value="">Select Status</option>
                            <option @if (request()->get('status') == 'publish') selected @endif value="publish">Active</option>
                            <option @if (request()->get('status') == 'passive') selected @endif value="passive">Passive</option>
                            <option @if (request()->get('status') == 'draft') selected @endif value="draft">Draft</option>
                        </select>
                    </div>
                    @if (request()->get('title') || request()->get('status'))
                        <!-- eğer filtre varsa sıfırla butonunu göstermesi için kullanıyoruz -->
                        <div class="col-md-2">
                            <a href="{{ route('quizzes.index') }}" class="btn btn-secondary">Sıfırla</a>
                        </div>
                    @endif
                </div>
            </form>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th scope="col">Quiz</th>
                        <th scope="col">Number of Questions</th>
                        <th scope="col">Status</th>
                        <th scope="col">Finish Date</th>
                        <th scope="col">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($quizzes as $quiz)
                        <tr>
                            <td>{{ $quiz->title }}</td>
                            <td>{{ $quiz->questions_count }}</td>
                            <td>
                                @switch($quiz->status)
                                    @case('publish')
                                    <span class="badge badge-success">Active</span>
                                    @break
                                    @case('passive')
                                    <span class="badge badge-danger">Passive</span>
                                    @break
                                    @case('draft')
                                    <span class="badge badge-warning">Draft</span>
                                    @break
                                    @default

                                @endswitch
                            </td>
                            <td>
                                <span title="{{ $quiz->finished_at }}">
                                    {{ $quiz->finished_at ? $quiz->finished_at->diffForHumans() : '-' }}
                                </span>
                            </td>
                            <td>
                                <a href="{{ route('questions.index', $quiz->id) }}" class="btn btn-sm btn-warning"><i
                                        class="fa fa-question"></i></a>

                                <a href="{{ route('quizzes.edit', $quiz->id) }}" class="btn btn-sm btn-primary"><i
                                        class="fa fa-pen"></i></a>

                                <a href="{{ route('quizzes.destroy', $quiz->id) }}" class="btn btn-sm btn-danger"><i
                                        class="fa fa-times"></i></a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            {{ $quizzes->withQueryString()->links() }}
            <!-- bu satırı kullanarak paginationu çağırdık ve böylece kayıtlar tek sayfada değil, her sayfada 5 tane olacak şekilde toplam 4 sayfada gözüktü -->
        </div>
    </div>
</x-app-layout>
