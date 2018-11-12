

from django.urls import path
from . import views


urlpatterns = [
    path('', views.contact, name="contact"),
    path('form', views.post_new, name="articleForm")
]
