<a href="{{ $href }}"
   class="w-full inline-flex items-center px-4 py-2 border text-sm font-medium rounded-md transition-colors duration-200
   @if ($primary) border-transparent text-white hover:bg-blue-700"
       style="background-color: #003977;
   @else
       border-gray-300 text-gray-700 bg-white hover:bg-gray-50 @endif
   ">
    <i class="{{ $icon }} mr-2"></i>
    {{ $text }}
</a>
