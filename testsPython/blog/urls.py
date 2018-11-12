# BLOG ROUTING

from django.urls import path
from . import views

urlpatterns = [
    path('', views.home),
    path('article/<int:id_article>', views.view_article),
    path('article/<int:id_article>/<int:year>/<int:month>', views.list_articles),
    
]
