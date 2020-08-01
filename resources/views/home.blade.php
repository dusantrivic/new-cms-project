<x-home-master>

@section('content')

<h1 class="my-4">Page Heading
    <small>Secondary Text sa dusan grane</small>
  </h1>
 @foreach($posts as $post)
  <!-- Blog Post -->
  <div class="card mb-4">
    <img class="card-img-top"   src="{{ route('post.image',$post->id) }} " alt="Card image cap">
    <div class="card-body">
      <h2 class="card-title">{{$post->title}}</h2>
      <p class="card-text">{{Str::limit($post->body,'50','...')}}</p>
      <a href="{{route('post',$post->id)}}" class="btn btn-primary">Read More &rarr;</a>

<div>
      @if(Auth::check())
      @if(!auth()->user()->likes->contains($post))

      <form method="post" action="{{route('post.like',$post->id)}}" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <input type="hidden" name="like" value="{{$post->id}}">
        <button class="btn btn-primary btn-circle" style="position:absolute; right: 5%; bottom:5%" ><i class="fas fa-check"></i></button>
      <a class="btn btn-primary btn-circle" style="position:absolute; right: 15%; bottom:5%"><i style="color: white">{{$post->likes}}</i></a>
    </form>
    @else
    <form method="post" action="{{route('post.dislike',$post->id)}}" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <input type="hidden" name="like" value="{{$post->id}}">
        <button class="btn btn-danger btn-circle" style="position: absolute; right: 5%; bottom:5%" >
            <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-x" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
            <path fill-rule="evenodd" d="M11.854 4.146a.5.5 0 0 1 0 .708l-7 7a.5.5 0 0 1-.708-.708l7-7a.5.5 0 0 1 .708 0z"/>
            <path fill-rule="evenodd" d="M4.146 4.146a.5.5 0 0 0 0 .708l7 7a.5.5 0 0 0 .708-.708l-7-7a.5.5 0 0 0-.708 0z"/>
          </svg>
        </button>
        <a class="btn btn-primary btn-circle " style="position:absolute; right: 15%; bottom:5%"><i style="color: white">{{$post->likes}}</i></a>

    </form>
    @endif
    @endif




    </div>
    </div>
    <div class="card-footer text-muted">
      Posted on {{$post->created_at->diffForHumans()}} by {{$post->user->username}}



    </div>
  </div>

  @endforeach
  <!-- Pagination -->
  <ul class="pagination justify-content-center mb-4">
    <li class="page-item">
      <a class="page-link" href="#">&larr; Older</a>
    </li>
    <li class="page-item disabled">
      <a class="page-link" href="#">Newer &rarr;</a>
    </li>
  </ul>

@endsection
</x-home-master>
