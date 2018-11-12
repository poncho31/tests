from django.http import HttpResponse
from django.shortcuts import render


def home(request):
    return HttpResponse("""  HOMEPAGE   """)
# Create your views here.
