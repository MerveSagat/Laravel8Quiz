<x-app-layout>
    <x-slot name="header"> {{ $quiz->title }} </x-slot>
    <div class="card">
        <div class="card-body">
            <p class="card-text">
            <div class="row">
                <div class="col-md-4">
                    <ul class="list-group">
                        @if($quiz->finished_at)
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            Last Attended Date
                            <span title="{{ $quiz->finished_at }}"  class="badge badge-secondary badge-pill">{{ $quiz->finished_at->diffForHumans() }}</span>
                        </li>
                        @endif
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            Number of Questions
                            <span class="badge badge-secondary badge-pill">{{ $quiz->questions_count }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            The number of participants
                            <span class="badge badge-secondary badge-pill">14</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            Avarage Point
                            <span class="badge badge-secondary badge-pill">60</span>
                        </li>
                    </ul>
                </div>
                <div class="col-md-8">
                    {{ $quiz->description }}</p>
                    <a href="#" class="btn btn-primary btn-block btn-sm">Take Quiz</a>
                </div>
            </div>
        </div>
</x-app-layout>
