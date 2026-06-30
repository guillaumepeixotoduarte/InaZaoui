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

/* front/portfolio.html.twig */
class __TwigTemplate_ba143073e0139c4d03f64845572e10a1 extends Template
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
            'front' => [$this, 'block_front'],
        ];
    }

    protected function doGetParent(array $context): bool|string|Template|TemplateWrapper
    {
        // line 1
        return "front.html.twig";
    }

    protected function doDisplay(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        $__internal_5a27a8ba21ca79b61932376b2fa922d2 = $this->extensions["Symfony\\Bundle\\WebProfilerBundle\\Twig\\WebProfilerExtension"];
        $__internal_5a27a8ba21ca79b61932376b2fa922d2->enter($__internal_5a27a8ba21ca79b61932376b2fa922d2_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "template", "front/portfolio.html.twig"));

        $__internal_6f47bbe9983af81f1e7450e9a3e3768f = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_6f47bbe9983af81f1e7450e9a3e3768f->enter($__internal_6f47bbe9983af81f1e7450e9a3e3768f_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "template", "front/portfolio.html.twig"));

        $this->parent = $this->load("front.html.twig", 1);
        yield from $this->parent->unwrap()->yield($context, array_merge($this->blocks, $blocks));
        
        $__internal_5a27a8ba21ca79b61932376b2fa922d2->leave($__internal_5a27a8ba21ca79b61932376b2fa922d2_prof);

        
        $__internal_6f47bbe9983af81f1e7450e9a3e3768f->leave($__internal_6f47bbe9983af81f1e7450e9a3e3768f_prof);

    }

    // line 3
    /**
     * @return iterable<null|scalar|\Stringable>
     */
    public function block_front(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        $__internal_5a27a8ba21ca79b61932376b2fa922d2 = $this->extensions["Symfony\\Bundle\\WebProfilerBundle\\Twig\\WebProfilerExtension"];
        $__internal_5a27a8ba21ca79b61932376b2fa922d2->enter($__internal_5a27a8ba21ca79b61932376b2fa922d2_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "block", "front"));

        $__internal_6f47bbe9983af81f1e7450e9a3e3768f = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_6f47bbe9983af81f1e7450e9a3e3768f->enter($__internal_6f47bbe9983af81f1e7450e9a3e3768f_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "block", "front"));

        // line 4
        yield "    <div class=\"row\">
        <div class=\"col-12\">
            <h3 class=\"mb-4\">Portfolio</h3>
            <div class=\"mb-5 row album-filter-list\">
                <div class=\"col-2\">
                    <a class=\"btn w-100 py-3 ";
        // line 9
        yield (((null === (isset($context["album"]) || array_key_exists("album", $context) ? $context["album"] : (function () { throw new RuntimeError('Variable "album" does not exist.', 9, $this->source); })()))) ? ("active") : (""));
        yield "\" href=\"";
        yield $this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("portfolio");
        yield "\">
                        Toutes
                    </a>
                </div>
                ";
        // line 13
        $context['_parent'] = $context;
        $context['_seq'] = CoreExtension::ensureTraversable((isset($context["albums"]) || array_key_exists("albums", $context) ? $context["albums"] : (function () { throw new RuntimeError('Variable "albums" does not exist.', 13, $this->source); })()));
        foreach ($context['_seq'] as $context["_key"] => $context["a"]) {
            // line 14
            yield "                    <div class=\"col-2 album-filter\">
                        <a class=\"btn w-100 py-3 ";
            // line 15
            yield ((((isset($context["album"]) || array_key_exists("album", $context) ? $context["album"] : (function () { throw new RuntimeError('Variable "album" does not exist.', 15, $this->source); })()) == $context["a"])) ? ("active") : (""));
            yield "\" href=\"";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("portfolio", ["id" => CoreExtension::getAttribute($this->env, $this->source, $context["a"], "id", [], "any", false, false, false, 15)]), "html", null, true);
            yield "\">
                            ";
            // line 16
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["a"], "name", [], "any", false, false, false, 16), "html", null, true);
            yield "
                        </a>
                    </div>
                ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_key'], $context['a'], $context['_parent']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 20
        yield "            </div>
            <div class=\"row media-list\">
                ";
        // line 22
        $context['_parent'] = $context;
        $context['_seq'] = CoreExtension::ensureTraversable((isset($context["medias"]) || array_key_exists("medias", $context) ? $context["medias"] : (function () { throw new RuntimeError('Variable "medias" does not exist.', 22, $this->source); })()));
        foreach ($context['_seq'] as $context["_key"] => $context["media"]) {
            // line 23
            yield "                    <div class=\"col-4 media mb-4\">
                        <img class=\"w-100\" src=\"";
            // line 24
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\AssetExtension']->getAssetUrl(CoreExtension::getAttribute($this->env, $this->source, $context["media"], "path", [], "any", false, false, false, 24)), "html", null, true);
            yield "\" alt=\"";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["media"], "title", [], "any", false, false, false, 24), "html", null, true);
            yield "\">
                        <p class=\"text-center mb-0 mt-2 media-title\">";
            // line 25
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["media"], "title", [], "any", false, false, false, 25), "html", null, true);
            yield "</p>
                    </div>
                ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_key'], $context['media'], $context['_parent']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 28
        yield "            </div>
        </div>
    </div>
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
        return "front/portfolio.html.twig";
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
        return array (  141 => 28,  132 => 25,  126 => 24,  123 => 23,  119 => 22,  115 => 20,  105 => 16,  99 => 15,  96 => 14,  92 => 13,  83 => 9,  76 => 4,  63 => 3,  40 => 1,);
    }

    public function getSourceContext(): Source
    {
        return new Source("{% extends \x27front.html.twig\x27 %}

{% block front %}
    <div class=\"row\">
        <div class=\"col-12\">
            <h3 class=\"mb-4\">Portfolio</h3>
            <div class=\"mb-5 row album-filter-list\">
                <div class=\"col-2\">
                    <a class=\"btn w-100 py-3 {{ album is null ? \x27active\x27 }}\" href=\"{{ path(\x27portfolio\x27) }}\">
                        Toutes
                    </a>
                </div>
                {% for a in albums %}
                    <div class=\"col-2 album-filter\">
                        <a class=\"btn w-100 py-3 {{ album == a ? \x27active\x27 }}\" href=\"{{ path(\x27portfolio\x27, {id: a.id}) }}\">
                            {{ a.name }}
                        </a>
                    </div>
                {% endfor %}
            </div>
            <div class=\"row media-list\">
                {% for media in medias %}
                    <div class=\"col-4 media mb-4\">
                        <img class=\"w-100\" src=\"{{ asset(media.path) }}\" alt=\"{{ media.title }}\">
                        <p class=\"text-center mb-0 mt-2 media-title\">{{ media.title }}</p>
                    </div>
                {% endfor %}
            </div>
        </div>
    </div>
{% endblock %}

", "front/portfolio.html.twig", "C:\\wamp64\\www\\876-p15-inazaoui-main\\templates\\front\\portfolio.html.twig");
    }
}
