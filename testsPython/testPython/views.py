from django.http import HttpResponse, Http404
from django.shortcuts import render, redirect


def view_redirection(request, id_article):
    return HttpResponse('Vous avez été redirigé. L\'article ' +
                        str(id_article) +
                        ' n\'existe pas')
