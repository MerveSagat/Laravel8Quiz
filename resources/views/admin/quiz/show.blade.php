<x-app-layout>
    <x-slot name="header"> {{ $quiz->title }} </x-slot>
    <div class="card">
        <div class="card-body">
            <p class="card-text">
                <h5 class="card-title">
                    <a href="{{route('quizzes.index')}}" class="btn btn-sm btn-secondary">
                        <i class="fa fa-arrow-left"></i> Back to Quizzes </a>
                </h5>
            <div class="row">
                <div class="col-md-4">
                    <ul class="list-group">
                        @if ($quiz->finished_at)
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                Last Attended Date
                                <span title="{{ $quiz->finished_at }}"
                                    class="badge badge-secondary badge-pill">{{ $quiz->finished_at->diffForHumans() }}</span>
                            </li>
                        @endif
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            Number of Questions
                            <span class="badge badge-secondary badge-pill">{{ $quiz->questions_count }}</span>
                        </li>
                        @if ($quiz->details)
                            <!-- bu ifin anlamı, eğer quiz details null değilse çalışsın demek-->
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                The number of participants
                                <span class="badge badge-warning badge-pill">{{ $quiz->details['join_count'] }}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                Avarage Point
                                <span class="badge badge-light badge-pill">{{ $quiz->details['average'] }}</span>
                            </li>
                        @endif
                    </ul>
                    @if(count($quiz->topTen)>0)
                    <div class="card mt-3">
                        <div class="card-body">
                            <h5 class="card-title">Top Ten</h5>
                            <ul class="list-group">
                                @foreach ($quiz->topTen as $result)
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        <strong class="h7"> {{ $loop->iteration }}.</strong>
                                        <img class="w-8 h-8 rounded-full" src="{{ $result->user->profile_photo_url }}">
                                        <span @if(auth()->user()->id==$result->user_id)class="text-danger" @endif>{{ $result->user->name }}</span>
                                        <span class="badge badge-success badge-pill">{{ $result->point }}</span>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    @endif
                </div>

                <div class="col-md-8">
                    {{ $quiz->description }}

                    <table class="table table-bordered mt-3">
                        <thead>
                          <tr>
                            <th scope="col">Full Name</th>
                            <th scope="col">Point</th>
                            <th scope="col">Correct</th>
                            <th scope="col">Wrong</th>
                          </tr>
                        </thead>
                        <tbody>
                            @foreach($quiz->results as $result)
                          <tr>
                            <td>{{ $result->user->name }}</td>
                            <td>{{ $result->point }}</td>
                            <td>{{ $result->correct }}</td>
                            <td>{{ $result->wrong }}</td>
                          </tr>
                          @endforeach
                        </tbody>
                      </table>
                    </p>
                </div>
            </div>
        </div>
</x-app-layout>
