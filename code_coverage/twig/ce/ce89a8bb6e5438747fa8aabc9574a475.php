<?php

use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Extension\CoreExtension;
use Twig\Extension\SandboxExtension;
use Twig\Markup;
use Twig\Sandbox\SecurityError;
use Twig\Sandbox\SecurityNotAllowedTagError;
use Twig\Sandbox\SecurityNotAllowedFilterError;
use Twig\Sandbox\SecurityNotAllowedFunctionError;
use Twig\Source;
use Twig\Template;
use Twig\TemplateWrapper;

/* admin/media/index.html.twig */
class __TwigTemplate_f7752def7440ee2e3045c10a04360ce8 extends Template
{
    private Source $source;
    /**
     * @var array<string, Template>
     */
    private array $macros = [];

    public function __construct(Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        $this->blocks = [
            'admin' => [$this, 'block_admin'],
        ];
    }

    protected function doGetParent(array $context): bool|string|Template|TemplateWrapper
    {
        // line 1
        return "admin.html.twig";
    }

    protected function doDisplay(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        $__internal_5a27a8ba21ca79b61932376b2fa922d2 = $this->extensions["Symfony\\Bundle\\WebProfilerBundle\\Twig\\WebProfilerExtension"];
        $__internal_5a27a8ba21ca79b61932376b2fa922d2->enter($__internal_5a27a8ba21ca79b61932376b2fa922d2_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "template", "admin/media/index.html.twig"));

        $__internal_6f47bbe9983af81f1e7450e9a3e3768f = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_6f47bbe9983af81f1e7450e9a3e3768f->enter($__internal_6f47bbe9983af81f1e7450e9a3e3768f_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "template", "admin/media/index.html.twig"));

        $this->parent = $this->load("admin.html.twig", 1);
        yield from $this->parent->unwrap()->yield($context, array_merge($this->blocks, $blocks));
        
        $__internal_5a27a8ba21ca79b61932376b2fa922d2->leave($__internal_5a27a8ba21ca79b61932376b2fa922d2_prof);

        
        $__internal_6f47bbe9983af81f1e7450e9a3e3768f->leave($__internal_6f47bbe9983af81f1e7450e9a3e3768f_prof);

    }

    // line 3
    /**
     * @return iterable<null|scalar|\Stringable>
     */
    public function block_admin(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        $__internal_5a27a8ba21ca79b61932376b2fa922d2 = $this->extensions["Symfony\\Bundle\\WebProfilerBundle\\Twig\\WebProfilerExtension"];
        $__internal_5a27a8ba21ca79b61932376b2fa922d2->enter($__internal_5a27a8ba21ca79b61932376b2fa922d2_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "block", "admin"));

        $__internal_6f47bbe9983af81f1e7450e9a3e3768f = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_6f47bbe9983af81f1e7450e9a3e3768f->enter($__internal_6f47bbe9983af81f1e7450e9a3e3768f_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "block", "admin"));

        // line 4
        yield "    <div class=\"d-flex justify-content-between align-items-center\">
        <h2 class=\"page-title fs-1\">Medias</h2>
        <a href=\"";
        // line 6
        yield $this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("admin_media_add");
        yield "\" class=\"btn btn-primary\">Ajouter</a>
    </div>
    <table class=\"table admin-media-table\">
        <thead>
            <tr>
                <th>Image</th>
                <th>Titre</th>
                ";
        // line 13
        if ((($tmp = $this->extensions['Symfony\Bridge\Twig\Extension\SecurityExtension']->isGranted("ROLE_ADMIN")) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
            // line 14
            yield "                    <th>Artiste</th>
                    <th>Album</th>
                ";
        }
        // line 17
        yield "                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            ";
        // line 21
        $context['_parent'] = $context;
        $context['_seq'] = CoreExtension::ensureTraversable((isset($context["medias"]) || array_key_exists("medias", $context) ? $context["medias"] : (function () { throw new RuntimeError('Variable "medias" does not exist.', 21, $this->source); })()));
        foreach ($context['_seq'] as $context["_key"] => $context["media"]) {
            // line 22
            yield "                <tr>
                    <td><img src=\"";
            // line 23
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\AssetExtension']->getAssetUrl(CoreExtension::getAttribute($this->env, $this->source, $context["media"], "path", [], "any", false, false, false, 23)), "html", null, true);
            yield "\" width=\"75\" /></td>
                    <td>";
            // line 24
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["media"], "title", [], "any", false, false, false, 24), "html", null, true);
            yield "</td>
                    ";
            // line 25
            if ((($tmp = $this->extensions['Symfony\Bridge\Twig\Extension\SecurityExtension']->isGranted("ROLE_ADMIN")) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
                // line 26
                yield "                        <td>";
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, $context["media"], "user", [], "any", false, false, false, 26), "name", [], "any", false, false, false, 26), "html", null, true);
                yield "</td>
                        <td>";
                // line 27
                yield (((CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, $context["media"], "album", [], "any", false, true, false, 27), "name", [], "any", true, true, false, 27) &&  !(null === CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, $context["media"], "album", [], "any", false, false, false, 27), "name", [], "any", false, false, false, 27)))) ? ($this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, $context["media"], "album", [], "any", false, false, false, 27), "name", [], "any", false, false, false, 27), "html", null, true)) : (""));
                yield "</td>
                    ";
            }
            // line 29
            yield "                    <td>
                        <a href=\"";
            // line 30
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("admin_media_delete", ["id" => CoreExtension::getAttribute($this->env, $this->source, $context["media"], "id", [], "any", false, false, false, 30)]), "html", null, true);
            yield "\" class=\"btn btn-danger\">Supprimer</a>
                    </td>
                </tr>
            ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_key'], $context['media'], $context['_parent']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 34
        yield "        </tbody>
    </table>
    ";
        // line 36
        $context["totalPages"] = Twig\Extension\CoreExtension::round(((isset($context["total"]) || array_key_exists("total", $context) ? $context["total"] : (function () { throw new RuntimeError('Variable "total" does not exist.', 36, $this->source); })()) / 25), 0, "ceil");
        // line 37
        yield "
    <nav aria-label=\"Page navigation\">
        <ul class=\"pagination\">
            ";
        // line 40
        if (((isset($context["page"]) || array_key_exists("page", $context) ? $context["page"] : (function () { throw new RuntimeError('Variable "page" does not exist.', 40, $this->source); })()) > 1)) {
            // line 41
            yield "                <li class=\"page-item\">
                    <a class=\"page-link\" href=\"";
            // line 42
            yield $this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("admin_media_index", ["page" => 1]);
            yield "\">Première page</a>
                </li>
                <li class=\"page-item\">
                    <a class=\"page-link\" href=\"";
            // line 45
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("admin_media_index", ["page" => ((isset($context["page"]) || array_key_exists("page", $context) ? $context["page"] : (function () { throw new RuntimeError('Variable "page" does not exist.', 45, $this->source); })()) - 1)]), "html", null, true);
            yield "\">Précédent</a>
                </li>
            ";
        }
        // line 48
        yield "
            ";
        // line 49
        $context['_parent'] = $context;
        $context['_seq'] = CoreExtension::ensureTraversable(range(max(1, ((isset($context["page"]) || array_key_exists("page", $context) ? $context["page"] : (function () { throw new RuntimeError('Variable "page" does not exist.', 49, $this->source); })()) - 3)), min((isset($context["totalPages"]) || array_key_exists("totalPages", $context) ? $context["totalPages"] : (function () { throw new RuntimeError('Variable "totalPages" does not exist.', 49, $this->source); })()), ((isset($context["page"]) || array_key_exists("page", $context) ? $context["page"] : (function () { throw new RuntimeError('Variable "page" does not exist.', 49, $this->source); })()) + 3))));
        foreach ($context['_seq'] as $context["_key"] => $context["i"]) {
            // line 50
            yield "                <li class=\"page-item ";
            if (($context["i"] == (isset($context["page"]) || array_key_exists("page", $context) ? $context["page"] : (function () { throw new RuntimeError('Variable "page" does not exist.', 50, $this->source); })()))) {
                yield "active";
            }
            yield "\">
                    <a class=\"page-link\" href=\"";
            // line 51
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("admin_media_index", ["page" => $context["i"]]), "html", null, true);
            yield "\">";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($context["i"], "html", null, true);
            yield "</a>
                </li>
            ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_key'], $context['i'], $context['_parent']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 54
        yield "
            ";
        // line 55
        if (((isset($context["page"]) || array_key_exists("page", $context) ? $context["page"] : (function () { throw new RuntimeError('Variable "page" does not exist.', 55, $this->source); })()) < (isset($context["totalPages"]) || array_key_exists("totalPages", $context) ? $context["totalPages"] : (function () { throw new RuntimeError('Variable "totalPages" does not exist.', 55, $this->source); })()))) {
            // line 56
            yield "                <li class=\"page-item\">
                    <a class=\"page-link\" href=\"";
            // line 57
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("admin_media_index", ["page" => ((isset($context["page"]) || array_key_exists("page", $context) ? $context["page"] : (function () { throw new RuntimeError('Variable "page" does not exist.', 57, $this->source); })()) + 1)]), "html", null, true);
            yield "\">Suivant</a>
                </li>
                <li class=\"page-item\">
                    <a class=\"page-link\" href=\"";
            // line 60
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("admin_media_index", ["page" => (isset($context["totalPages"]) || array_key_exists("totalPages", $context) ? $context["totalPages"] : (function () { throw new RuntimeError('Variable "totalPages" does not exist.', 60, $this->source); })())]), "html", null, true);
            yield "\">Dernière page</a>
                </li>
            ";
        }
        // line 63
        yield "        </ul>
    </nav>
";
        
        $__internal_6f47bbe9983af81f1e7450e9a3e3768f->leave($__internal_6f47bbe9983af81f1e7450e9a3e3768f_prof);

        
        $__internal_5a27a8ba21ca79b61932376b2fa922d2->leave($__internal_5a27a8ba21ca79b61932376b2fa922d2_prof);

        yield from [];
    }

    /**
     * @codeCoverageIgnore
     */
    public function getTemplateName(): string
    {
        return "admin/media/index.html.twig";
    }

    /**
     * @codeCoverageIgnore
     */
    public function isTraitable(): bool
    {
        return false;
    }

    /**
     * @codeCoverageIgnore
     */
    public function getDebugInfo(): array
    {
        return array (  216 => 63,  210 => 60,  204 => 57,  201 => 56,  199 => 55,  196 => 54,  185 => 51,  178 => 50,  174 => 49,  171 => 48,  165 => 45,  159 => 42,  156 => 41,  154 => 40,  149 => 37,  147 => 36,  143 => 34,  133 => 30,  130 => 29,  125 => 27,  120 => 26,  118 => 25,  114 => 24,  110 => 23,  107 => 22,  103 => 21,  97 => 17,  92 => 14,  90 => 13,  80 => 6,  76 => 4,  63 => 3,  40 => 1,);
    }

    public function getSourceContext(): Source
    {
        return new Source("{% extends \x27admin.html.twig\x27 %}

{% block admin %}
    <div class=\"d-flex justify-content-between align-items-center\">
        <h2 class=\"page-title fs-1\">Medias</h2>
        <a href=\"{{ path(\x27admin_media_add\x27) }}\" class=\"btn btn-primary\">Ajouter</a>
    </div>
    <table class=\"table admin-media-table\">
        <thead>
            <tr>
                <th>Image</th>
                <th>Titre</th>
                {% if is_granted(\x27ROLE_ADMIN\x27) %}
                    <th>Artiste</th>
                    <th>Album</th>
                {% endif %}
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            {% for media in medias %}
                <tr>
                    <td><img src=\"{{ asset(media.path) }}\" width=\"75\" /></td>
                    <td>{{ media.title }}</td>
                    {% if is_granted(\x27ROLE_ADMIN\x27) %}
                        <td>{{ media.user.name }}</td>
                        <td>{{ media.album.name ?? \x27\x27 }}</td>
                    {% endif %}
                    <td>
                        <a href=\"{{ path(\x27admin_media_delete\x27, {id: media.id}) }}\" class=\"btn btn-danger\">Supprimer</a>
                    </td>
                </tr>
            {% endfor %}
        </tbody>
    </table>
    {% set totalPages = (total / 25)|round(0, \x27ceil\x27) %}

    <nav aria-label=\"Page navigation\">
        <ul class=\"pagination\">
            {% if page > 1 %}
                <li class=\"page-item\">
                    <a class=\"page-link\" href=\"{{ path(\x27admin_media_index\x27, {page: 1}) }}\">Première page</a>
                </li>
                <li class=\"page-item\">
                    <a class=\"page-link\" href=\"{{ path(\x27admin_media_index\x27, {page: page - 1}) }}\">Précédent</a>
                </li>
            {% endif %}

            {% for i in range(max(1, page - 3), min(totalPages, page + 3)) %}
                <li class=\"page-item {% if i == page %}active{% endif %}\">
                    <a class=\"page-link\" href=\"{{ path(\x27admin_media_index\x27, {page: i}) }}\">{{ i }}</a>
                </li>
            {% endfor %}

            {% if page < totalPages %}
                <li class=\"page-item\">
                    <a class=\"page-link\" href=\"{{ path(\x27admin_media_index\x27, {page: page + 1}) }}\">Suivant</a>
                </li>
                <li class=\"page-item\">
                    <a class=\"page-link\" href=\"{{ path(\x27admin_media_index\x27, {page: totalPages}) }}\">Dernière page</a>
                </li>
            {% endif %}
        </ul>
    </nav>
{% endblock %}", "admin/media/index.html.twig", "C:\\wamp64\\www\\876-p15-inazaoui-main\\templates\\admin\\media\\index.html.twig");
    }
}
