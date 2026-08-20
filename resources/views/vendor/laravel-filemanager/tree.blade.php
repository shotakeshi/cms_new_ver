<ul class="nav nav-pills flex-column">
  @foreach($root_folders as $root_folder)
    <li class="nav-item">
      <a class="nav-link" href="#" data-type="0" data-path="{{ $root_folder->url }}">
        <span class="mr-3 text-warning d-inline-block">📁</span> {{ $root_folder->name }}
      </a>
    </li>
    @foreach($root_folder->children as $directory)
    <li class="nav-item sub-item ml-3">
      <a class="nav-link" href="#" data-type="0" data-path="{{ $directory->url }}">
          <span class="mr-3 text-warning d-inline-block">📁</span> {{ $directory->name }}
      </a>
    </li>
    @endforeach
  @endforeach
</ul>
